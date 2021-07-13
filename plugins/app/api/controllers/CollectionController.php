<?php

namespace app\api\controllers;

use Yii;
use app\core\models\Libgenrelist;
use app\core\models\Libbook;
use app\core\models\Librate;

use app\core\models\UserCollection;
use app\core\models\UserCollectionBook;

class CollectionController extends BaseController
{
    public function actionList()
    {
        $user = Yii::$app->user;

        $collections = UserCollection::find()->where(['user_id' => $user->id])->all();

        return [
            'ok' => true,
            'collections' => $collections,
        ];
    }

    public function actionCreate()
    {
        $name = Yii::$app->request->post('name');

        $collection = new UserCollection();

        $collection->name = $name;
        $collection->user_id = Yii::$app->user->id;
        

        return [
            'ok' => $collection->save(),
            'collection' => $collection,
        ];
    }

    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
        $collection = UserCollection::find()->where([
            'user_id'=> Yii::$app->user->id,
            'id' => $id
        ])->one();

        if (!$collection) {
            return [
                'ok' => false
            ];
        }

        $collection->delete();

        return [
            'ok' => true,
        ];
    }

    public function actionUpdate()
    {
        $id = Yii::$app->request->post('id');

        $collection = UserCollection::find()->where([
            'user_id'=> Yii::$app->user->id,
            'id' => $id
        ])->one();

        if (!$collection) {
            return [
                'ok' => false
            ];
        }

        $collection->name = Yii::$app->request->post('name');
        $collection->save();

        return [
            'ok' => true,
        ];
    }

    public function actionAddBook()
    {
        $id = Yii::$app->request->post('id');
        $bookId = Yii::$app->request->post('bookId');

        $collection = UserCollection::find()->where([
            'user_id'=> Yii::$app->user->id,
            'id' => $id
        ])->one();

        if (!$collection) {
            return [
                'ok' => false
            ];
        }
        
        $book = Libbook::findOne($bookId)   ;

        if (!$book) {
            return [
                'ok' => false
            ];
        }

        $collectionBook = UserCollectionBook::find()->where([
            'book_id' => $book->BookId,
            'collection_id' => $collection->id
        ])->one();

        if (!$collectionBook) {
            $collectionBook = new UserCollectionBook();
            $collectionBook->book_id = $book->BookId;
            $collectionBook->collection_id = $collection->id;
            $collectionBook->save();
        }

        return [
            'ok' => true,
        ];
    }

    public function actionRemoveBook()
    {
        $id = Yii::$app->request->post('id');
        $bookId = Yii::$app->request->post('bookId');

        $collection = UserCollection::find()->where([
            'user_id'=> Yii::$app->user->id,
            'id' => $id
        ])->one();

        if (!$collection) {
            return [
                'ok' => false
            ];
        }
        
        $book = Libbook::findOne($bookId)   ;

        if (!$book) {
            return [
                'ok' => false
            ];
        }

        $collectionBook = UserCollectionBook::find()->where([
            'book_id' => $book->BookId,
            'collection_id' => $collection->id
        ])->one();

        if ($collectionBook) {
            $collectionBook->delete();
        }

        return [
            'ok' => true,
        ];
    }

    public function actionBooks($id)
    {
        $collection = UserCollection::find()->where([
            'user_id'=> Yii::$app->user->id,
            'id' => $id
        ])->one();

        if (!$collection) {
            return [
                'ok' => false
            ];
        }

        return [
            'ok' => true,
            'collectionBooks' => UserCollectionBook::find()->where([
                'collection_id' => $collection->id
            ])->all()
        ];
    }
}
