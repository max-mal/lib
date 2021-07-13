<?php

namespace app\api\controllers;

use Yii;
use app\core\models\Libavtorname;
use app\core\models\Libavtor;

class AuthorController extends BaseController
{

    public function actionList($page = 1, $query = '')
    {
        $cache = Yii::$app->cache;

        $list = Libavtorname::find()->limit(20)->offset(($page -1) * 20);
        if ($query) {
            // $list->where([
            //     'or',
            //     ['FirstName' => $query],
            //     ['LastName' => $query],
            //     ['like', 'FirstName', $query],
            //     ['like', 'LastName', $query],
            // ]);

            $q = Yii::$app->db->quoteValue($query);
            $list->where("MATCH(FirstName,LastName) AGAINST 
                ($q )");
        }

        $countQuery = Libavtor::find()->where('libavtor.AvtorId = libavtorname.AvtorId')->select(['COUNT(*)']);

        $list->select([
            'libavtorname.*',
            'count' => $countQuery
        ]);

        $list->andWhere([
            '>', $countQuery, 0
        ]);

        $responseList = $cache->getOrSet('author-' . $page . '-'.  $query, function () use ($page, $query, $list) {
            
            $list = $list->all();
            $responseList = [];
            foreach ($list as $item) {
                $responseList[] = [
                    'id' => $item->AvtorId,
                    'name' => $item->FirstName,
                    'surname' => $item->LastName,
                    'picture' => $item->getPicture(),
                    'count' => $item->count,
                    'description' => $item->getDescription(),
                    'isDeleted' => false,
                ];
            }
            return $responseList;
        }, 60000000);
        

        return [
            'ok' => true,
            'authors' => $responseList,
            'pages' =>  ceil($list->count() / 20) + 1,
        ];
    }

    public function actionGet($id)
    {
        $author = Libavtorname::find()->where(['AvtorId' => $id])->one();

        if (!$author) {
            return [
                'ok' => false
            ];
        }

        return [
            'ok' => true,
            'author' => [
                'id' => $author->AvtorId,
                'name' => $author->FirstName,
                'surname' => $author->LastName,
                'picture' =>  $author->getPicture(),
                'count' => $author->getBooks()->count(),
                'description' => $author->getDescription(),
                'isDeleted' => false,
            ]
        ];
    }

    public function actionByGenres($genres, $page = 1)
    {
        $list = Libavtorname::find();

        $list->innerJoin(
            'libavtor',
            'libavtor.AvtorId = libavtorname.AvtorId'
        );

        $list->innerJoin(
            'libgenre',
            'libgenre.BookId = libavtor.BookId'
        );

        $list->where([
            'in', 'libgenre.GenreId', explode(',', $genres),
        ]);
        
        $responseList = Yii::$app->cache->getOrSet('author--' . $page . '-'.  $genres, function () use ($page, $list, $genres) {
            $responseList = [];
            foreach ($list->limit(20)->offset(($page -1) * 20)->all() as $item) {
                $responseList[] = [
                    'id' => $item->AvtorId,
                    'name' => $item->FirstName,
                    'surname' => $item->LastName,
                    'picture' => $item->getPicture(),
                    'count' => $item->getBooks()->count(),
                    'description' => $item->getDescription(),
                    'isDeleted' => false,
                ];
            }

            return $responseList;
        }, 60000000);

        return [
            'ok' => true,
            'authors' => $responseList,
            'pages' =>  ceil($list->count() / 20) + 1,
        ];
    }

    public function actionImage($id)
    {
        $author = Libavtorname::findOne($id);

        if (!$author || !$author->pic || !file_exists('/media/pi/DATA/fb.a.pics/' . $author->pic->File)) {
            header('Location: /logo/project-default.png');
            die();
        }
        $path = '/media/pi/DATA/fb.a.pics/' . $author->pic->File;
        header('Content-Type: ' . mime_content_type($path));
        echo file_get_contents($path);
        die();
    }
}
