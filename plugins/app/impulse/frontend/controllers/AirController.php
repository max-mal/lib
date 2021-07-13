<?php

namespace app\impulse\frontend\controllers;

use app\impulse\components\Impulse;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

class AirController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verb' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'push' => ['post'],
                ],
            ],
        ];
    }

    public function actionPush()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $request = \Yii::$app->request;

        $level = $request->post('level', Impulse::LEVEL_INFO);
        $category = $request->post('category');
        $message = $request->post('message');

        if (\Yii::$app->impulse->air($category, $message, $level)) {
            return [
                'result' => true,
            ];
        }

        throw new BadRequestHttpException('Не удалось записать лог');
    }
}
