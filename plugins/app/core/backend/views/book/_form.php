<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use app\core\models\Libavtor;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\core\models\Libbook */
/* @var $form yii\widgets\ActiveForm */

$dataProviderAvtor = new ActiveDataProvider([
    'query' => Libavtor::find()->where(['BookId' => $model->BookId]),
]);
?>

<div class="libbook-form">

    <?php $form = ActiveForm::begin(); ?>

    

    

    <?= $form->field($model, 'Title')->textInput(['maxlength' => true]) ?>    

    <?= $form->field($model, 'Lang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LangEx')->textInput() ?>
   

    <?= $form->field($model, 'Year')->textInput() ?>

    <?= $form->field($model, 'Deleted')->textInput(['maxlength' => true]) ?>
   
    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Pages')->textInput() ?>

    <?= $form->field($model, 'Chars')->textInput() ?>

    <?= $form->field($model, 'FileSize')->textInput() ?>

    <?= $form->field($model, 'Time')->textInput() ?>

    <?php if ($model->BookId) : ?>
        <?= GridView::widget([
            'dataProvider' => $dataProviderAvtor,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'BookId',
                'AvtorId',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        return Url::to(['/core/book-avtor/'.$action, 'id' => $model->BookId]);
                    }
                ],
            ],
        ]); ?>
    <?php endif;?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
