<?php

namespace app\api\controllers;

use Yii;
use platform\models\LoginForm;
use yii2mod\user\models\SignupForm;
use yii2mod\user\actions\SignupAction;
use yii2mod\user\traits\EventTrait;

class AuthController extends BaseController
{
    use EventTrait;

    public function behaviors()
    {
        return [];
    }

    public function actionProbe()
    {
        return [
            'ok' => true,
        ];
    }

    
    public function actionLogin()
    {
        $model = new LoginForm();
        $model->email = Yii::$app->request->post('username');
        $model->password = Yii::$app->request->post('password');

        if ($model->login()) {
            return [
                'ok' => true,
                'token' => Yii::$app->user->identity->auth_key,
            ];
        }
        
        return [
            'ok' => false,
            'error' => $model->getErrors(),
        ];
    }

    public function actionRegister()
    {
        $model = new SignupForm();
        $event = $this->getFormEvent($model);
        $model->email = Yii::$app->request->post('email');
        $model->username = $model->email;
        $model->password = Yii::$app->request->post('password');

        if (($user = $model->signup()) !== null) {
            $this->trigger(SignupAction::EVENT_AFTER_SIGNUP, $event);
            if (Yii::$app->getUser()->login($user)) {
                return [
                    'ok' => true,
                    'token' => Yii::$app->user->identity->auth_key,
                ];
            }
        }

        return [
            'ok' => false,
            'error' => $model->getErrors(),
        ];
    }
}
