<?php


namespace app\api\controllers;

use Yii;
use platform\models\User;
use yii\web\Response;
use yii\filters\AccessControl;
use app\core\models\Libbook;
use DOMDocument;
use app\core\models\Librate;

class PromoController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function beforeAction($action)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    public function actionBooks()
    {        
        $perPage = 20;
        $books = Libbook::find();  
        
                
        $books->select([
            'libbook.*',
            'Rate' => Librate::find()->where('librate.BookId = libbook.BookId')->select(['SUM(librate.Rate)']),
        ]);

        
        $books->orderBy([
            'Rate' => SORT_DESC,
        ]);
        
        $result = [];   
        foreach ($books->limit($perPage)->all() as $book) {
            $result[] = [
                'id' => $book->BookId,
                'picture' => $book->getImageUrl(true),
            ];
        }
    
        return [
            'ok' => true,
            'books' => $result,
        ];
    }

    public function actionImage($bookId)
    {        
        $book = Libbook::findOne($bookId);
        return $this->redirect($book->getImage());
    }
}
