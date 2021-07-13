<?php

namespace app\api\controllers;

use Yii;
use app\core\models\Libgenrelist;
use app\core\models\Libbook;
use app\core\models\Librate;

use app\core\models\BookProgress;
use app\core\models\Libavtor;
use app\core\models\Libgenre;
use yii\helpers\ArrayHelper;
use PHPHtmlParser\Dom;
use DOMDocument;
use app\core\models\BookChapter;
use Exception;
use app\core\models\Libreviews;
use app\core\models\UserGenre;

class BooksController extends BaseController
{
    public function actionList($genres = null, $authors = null, $page = 1, $popular = false, $query = '', $reading = '', $noCache = false, $seq = null)
    {
        $startTime = microtime(true);
        $perPage = 10;
        $books = Libbook::find()->where([
            'FileType' => 'fb2'
        ])->with(['author', 'authors', 'libGenres', 'seqs', 'progress']);

        if ($genres) {
            $books->innerJoin(
                'libgenre',
                'libbook.BookId = libgenre.BookId'
            );

            $books->andWhere([
                'in', 'libgenre.GenreId', explode(',', $genres),
            ]);
        }

        if ($seq) {
            $books->innerJoin(
                'libseq',
                'libbook.BookId = libseq.BookId'
            );

            $books->andWhere([
                'in', 'libseq.SeqId', explode(',', $seq),
            ]);
        }

        if ($authors) {
            // $books->joinWith([
            //     'author' => function (\yii\db\ActiveQuery $query) use ($authors) {
            //         $query->andWhere(['in', '{{libavtor}}.AvtorId' , explode(',', $authors)]);
            //     }
            // ], false);

            $books->innerJoin(
                'libavtor',
                'libbook.BookId = libavtor.BookId'
            );

            $books->andWhere([
                'in', 'libavtor.AvtorId', explode(',', $authors),
            ]);
        }
        

        $books->orderBy(['Time' => SORT_DESC])->andWhere([
            'Deleted' => 0,
        ]);
                        

        if ($popular) {        

            $books->select([
                'libbook.*',
                'Rate' => Librate::find()->where('librate.BookId = libbook.BookId')->select(['SUM(librate.Rate)']),
            ]);

            $books->orderBy([
                'Rate' => SORT_DESC,
            ]);
        }

        if ($query) {
            $books->andWhere([
                'like', 'Title', $query
            ]);
        }

        if ($reading) {
            $books->andWhere([
                'in', 'BookId', ArrayHelper::getColumn(BookProgress::find()->where(['user_id' => Yii::$app->user->identity->id])->all(), 'book_id')
            ]);
            $noCache = true;
        }

        if ($noCache) {
            $noCache = uniqid();
        } else {
            $noCache = '';
        }

        $result = Yii::$app->cache->getOrSet('books-fb2-' . $page . '-'.  $genres . '-' . $authors . $query . $reading . $noCache . ($popular ? 'popular' : '') . $seq, function () use ($books, $authors, $genres, $page, $popular, $perPage) {

            $result = [];

            foreach ($books->limit($perPage)->offset(($page -1) * $perPage)->all() as $book) {
                $result[] = $book->toResponse();                
            }

            return $result;
        }, 4 * 60 * 60);

        $count = $books->count();
        $pages = $count < $perPage? 1 : ceil($count / $perPage);

        if ($count > $perPage && $count % $perPage != 0) {
            $pages += 1;
        }

        return [
            'ok' => true,
            'time' => (microtime(true) - $startTime),
            'sql' => $books->createCommand()->getRawSql(),
            'books' => $result,
            'pages' =>  $pages,
            'total' => $count
        ];
    }

    public function actionChapters($id)
    {
        $book = Libbook::findOne($id);

        $chapters = BookChapter::find()->where([
            'book_id' => $id,
        ])->all();

        if (!$chapters) {
            $chapters = $book->parseBook($book);
        }
                
        return [
            'ok' => true,
            'chapters' => $chapters,
        ];
    }

    public function actionSetProgress()
    {
        $id = Yii::$app->request->post('id');
        $userProgress = Yii::$app->request->post('progress', 0);
        $currentChapter = Yii::$app->request->post('currentChapter', 0);

        $book = Libbook::findOne($id);
        if (!$book) {
            return [
                'ok' => false,
                'message' => 'No such book found',
            ];
        }

        $progress = BookProgress::find()->where([
            'user_id' => Yii::$app->user->id,
            'book_id' => $book->BookId,
        ])->one();

        if (!$progress) {
            $progress = new BookProgress();
            $progress->user_id = Yii::$app->user->id;
            $progress->book_id = $book->BookId;
        }

        $progress->progress = $userProgress;
        $progress->chapter = $currentChapter;

        $progress->save();

        return [
            'ok' => true,
        ];
    }

    public function actionRecs($page = 1)
    {
        
        $genreIds = Yii::$app->cache->getOrSet('recs-' . Yii::$app->user->id, function() use ($page){

            $readingBooks = BookProgress::find()->where([
                'user_id' => Yii::$app->user->id,
            ])->andWhere(['>', 'progress', 15])->all();

            $genreIds = [];

            foreach ($readingBooks as $progress) {
                $genres = Libgenre::find()->where(['BookId' => $progress->book_id])->all();

                foreach ($genres as $genre) {
                    $genreIds[] = $genre->GenreId;
                }
            }

            foreach (UserGenre::find()->where([
                'user_id' => Yii::$app->user->id,
            ])->all() as $userGenre) {
                $genreIds[] = $userGenre->genre_id;
            }

            $genreIds = array_unique($genreIds);    
            shuffle($genreIds);

            $genreIds = array_slice($genreIds, 0, 3);
            return $genreIds;
        }, 3 * 60 * 60);
        

        return Yii::$app->runAction('api/books/list', ['genres' => join(',', $genreIds), 'popular' => 1, 'page' => $page]);
    }

    public function actionGet($id)
    {
        $book = Libbook::find()->where([
            'BookId' => $id
        ]);

        $book->select([
            'libbook.*',
            'rate' => Librate::find()->where('librate.BookId = libbook.BookId')->select(['SUM(librate.Rate)']),
        ]);

        $book = $book->one();

        if (!$book) {
            return [
                'ok' => false,
            ];
        }

        return [
            'ok' => true,
            'book' => $book->toResponse(),
        ];
    }

    public function actionImage($bookId)
    {        
        $book = Libbook::find()->where(['BookId' => $bookId])->one();

        if (!$book) {
            return '/logo/project-default.png';
        }
    
        return $this->redirect($book->getImage());
    }

    public function actionTest($bookId)
    {
        $book = Libbook::find()->where(['BookId' => $bookId])->one();
        
        header('Content-Type: image/png');
        // Создание изображения
        $im = imagecreatetruecolor(200, 300);

        // Создание цветов
        $white = imagecolorallocate($im, 255, 255, 255);
        $grey = imagecolorallocate($im, 128, 128, 128);
        $black = imagecolorallocate($im, 0, 0, 0);
        imagefilledrectangle($im, 0, 0, 200, 300, $white);
        imagefilledrectangle($im, 0, 0, 5, 300, $grey);

        // Текст надписи
        $text = $book->Title;
        $arr = explode(' ', $text);

        foreach ($arr as $key => $item) {
            if ($key % 3 == 0) {
                $arr[$key] = "\n" . $arr[$key];
            }
        }

        $text = implode(' ', $arr);
        // Замена пути к шрифту на пользовательский
        $font = '/usr/share/fonts/truetype/freefont/FreeSans.ttf';


        $size = 20;
        $fits = false;
        while (!$fits) {
            $bounds = imagettfbbox($size, 0, $font, $text);
            if ($bounds[2] > 190) {
                $size--;
                continue;
            }

            $fits = true;
        }
        // Тень
        imagettftext($im, $size, 0, 10, 80, $black, $font, $text);
        imagettftext($im, 10, 0, 10, 80 + $bounds[1] + 20, $black, $font, $book->author->FirstName . ' ' . $book->author->MiddleName . "\n" . $book->author->LastName);


        imagepng($im);
        imagedestroy($im);

        die();
    }

    public function actionReviews($id)
    {
        $book = Libbook::findOne(['BookId' => $id]);

        if (!$book) {
            throw new Exception("Book not found");            
        }

        $reviews = Libreviews::find()->where([
            'BookId' => $book->BookId,
        ])->all();

        $responseReviews = [];

        foreach ($reviews as $review) {
            $responseReviews[] = [
                'bookId' => $review['BookId'],
                'time' => $review['Time'],
                'text' => $review['Text'],
                'username' => $review['Name'],
            ];
        }

        return [
            'ok' => true,
            'reviews' => $responseReviews,
        ];
    }
}
