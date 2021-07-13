<?php

namespace app\core\backend\controllers;

use Yii;
use app\core\models\Libavtor;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookAvtorController implements the CRUD actions for Libavtor model.
 */
class BookAvtorController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Libavtor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Libavtor::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Libavtor model.
     * @param integer $BookId
     * @param integer $AvtorId
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($BookId, $AvtorId)
    {
        return $this->render('view', [
            'model' => $this->findModel($BookId, $AvtorId),
        ]);
    }

    /**
     * Creates a new Libavtor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Libavtor();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'BookId' => $model->BookId, 'AvtorId' => $model->AvtorId]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Libavtor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $BookId
     * @param integer $AvtorId
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($BookId, $AvtorId)
    {
        $model = $this->findModel($BookId, $AvtorId);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'BookId' => $model->BookId, 'AvtorId' => $model->AvtorId]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Libavtor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $BookId
     * @param integer $AvtorId
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($BookId, $AvtorId)
    {
        $this->findModel($BookId, $AvtorId)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Libavtor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $BookId
     * @param integer $AvtorId
     * @return Libavtor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($BookId, $AvtorId)
    {
        if (($model = Libavtor::findOne(['BookId' => $BookId, 'AvtorId' => $AvtorId])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
