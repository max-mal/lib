<?php

namespace app\api\controllers;

use Yii;
use app\core\models\UserGenre;
use app\core\models\Libgenrelist;
use app\core\models\Libavtorname;
use app\core\models\UserAuthor;
use yii\web\UploadedFile;

class ProfileController extends BaseController
{

    public function actionGet()
    {
        return [
            'id' => Yii::$app->user->identity->id,
            'email' => Yii::$app->user->identity->email,
            'name' => Yii::$app->user->identity->profile->first_name,
            'lastName' => Yii::$app->user->identity->profile->last_name,
            'picture' => Yii::$app->user->identity->profile->avatar
        ];
    }

    public function actionUpdate()
    {
        $user = Yii::$app->user->identity;

        $email = Yii::$app->request->post('email', $user->email);
        $name = Yii::$app->request->post('name', $user->profile->first_name);
        $lastName = Yii::$app->request->post('lastName', $user->profile->last_name);

        

        $user->email = $email;
        $user->profile->first_name = $name;
        $user->profile->last_name = $lastName;

        if ($user->save() && $user->profile->save()) {
            return [
                'ok' => true
            ];
        }

        return [
            'ok' => false,
            'error' => array_merge($user->getErrors(), $user->profile->getErrors()),
        ];
    }

    public function actionAvatar()
    {
        $user = Yii::$app->user->identity;
            
        $file = UploadedFile::getInstanceByName('avatar');
        if (!$file) {
            return [
                'ok' => false,
                'message' => 'file not found',
            ];       
        }       
        $publicPath = '/uploads/avatars/' . $user->username . '.' . $file->extension;
        $file->saveAs(Yii::getAlias('@project') . '/web/static/' . $publicPath);

        $user->profile->avatar = Yii::getAlias('@staticUrl') . $publicPath;
        $user->profile->save();

        return [
            'ok' => true,
        ];
        
    }

    public function actionSetGenres()
    {
        $genres = Yii::$app->request->post('genres');

        $userGenres = UserGenre::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
        foreach ($userGenres as $uGenre) {
            $uGenre->delete();
        }

        foreach (explode(',', $genres) as $id) {
            if (Libgenrelist::find()->where(['GenreId' => $id])->one()) {
                $uGenre = new UserGenre();
                $uGenre->genre_id = $id;
                $uGenre->user_id = Yii::$app->user->identity->id;
                $uGenre->save();
            }
        }

        return ['ok' => true];
    }

    public function actionGetGenres()
    {
        return [
            'ok' => true,
            'genres' => UserGenre::find()->where(['user_id' => Yii::$app->user->identity->id])->all(),
        ];
    }

    public function actionSetAuthors()
    {
        $genres = Yii::$app->request->post('authors');

        $userGenres = UserAuthor::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
        foreach ($userGenres as $uGenre) {
            $uGenre->delete();
        }

        foreach (explode(',', $genres) as $id) {
            if (Libavtorname::find()->where(['AvtorId' => $id])->one()) {
                $uGenre = new UserAuthor();
                $uGenre->genre_id = $id;
                $uGenre->user_id = Yii::$app->user->identity->id;
                $uGenre->save();
            }
        }

        return ['ok' => true];
    }

    public function actionGetAuthors()
    {
        return [
            'ok' => true,
            'authors' => UserAuthor::find()->where(['user_id' => Yii::$app->user->identity->id])->all(),
        ];
    }

    public function actionPassword()
    {
        $newPassword = Yii::$app->request->post('password');
        if (!$newPassword) {
            return [
                'ok' => false,
                'message' => 'Пароль не должен быть пустым',
            ];
        }

        $user = Yii::$app->user->identity;
        $user->setPassword($newPassword);

        return [
            'ok' => true,            
        ];
    }
}
