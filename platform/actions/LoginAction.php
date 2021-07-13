<?php

namespace platform\actions;

use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 *
 */
class LoginAction extends \yii2mod\user\actions\LoginAction
{
    public $view = '@vendor/yii2mod/yii2-user/views/login';

    /**
     * @var string Login Form className
     */
    public $modelClass = \platform\models\LoginForm::class;

    public function run()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirectTo(Yii::$app->getHomeUrl());
        }

        $model = Yii::createObject($this->modelClass);
        $load = $model->load(Yii::$app->request->post());

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }

        if ($load && $model->login()) {
            return $this->redirectTo(Yii::$app->getUser()->getReturnUrl());
        }

        return $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }
}
