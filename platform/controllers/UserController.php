<?php

namespace platform\controllers;

use platform\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use platform\models\UserSearch;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends \yii\web\Controller
{

    

    /**
     * Updates an existing user Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionProfile($id)
    {
        $user = $this->findModel($id);
        $model = $user->profile;

        if (!$model) {
            throw new NotFoundHttpException();
        }

        if ($model->load(Yii::$app->getRequest()->post()) && $model->uploadAvatar() && $model->save() && $user->load(Yii::$app->getRequest()->post()) && $user->save()) {
            Yii::$app->getSession()->setFlash('success', 'Профиль обновлен');

            return $this->redirect(['profile', 'id' => $model->user_id]);
        } else {
            return $this->render('profile', [
                'model' => $model,
                'user' => $user,
            ]);
        }
    }

    private function findModel($id)
    {
        $user = User::findOne($id);

        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        return $user;
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $search = Yii::createObject(UserSearch::className());

        return $this->render('index', [
            'search' => $search,
            'dataProvider' => $search->search(
                Yii::$app->getRequest()->getQueryParams()
            ),
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Пользователь обновлен');

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;

        $model = new User();
        if (!$request->isPost) {
            return $this->render('create', ['model' => $model]);
        }

        if ($model->load($request->post()) && $model->create()) {
            Yii::$app->session->setFlash('success', 'Пользователь создан');
            return $this->redirect(['index']);
        }

        return $this->render('create', ['model' => $model]);
    }
}
