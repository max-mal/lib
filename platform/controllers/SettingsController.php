<?php
namespace platform\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

class SettingsController extends Controller
{
    public function actionIndex()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $post = $request->post();
            foreach ($post as $key => $value) {
                $name = explode('__', $key);
                if (count($name) !== 2) {
                    continue;
                }
                Yii::$app->settings->set($name[0], $name[1], $value);
            }
        }
        return $this->render('index');
    }
}
