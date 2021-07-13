<?php


namespace app\api\controllers;

use Yii;
use platform\models\User;
use yii\web\Response;
use yii\filters\AccessControl;

class BaseController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function beforeAction($action)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        if ($token = Yii::$app->request->get('token')) {
            $user = User::find()->where(['auth_key' => $token])->one();
            if ($user) {
                Yii::$app->user->login($user);
            }
        }
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
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
}
