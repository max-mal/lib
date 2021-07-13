<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\core\models\LibbookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="libbook-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'BookId') ?>

    <?= $form->field($model, 'FileSize') ?>

    <?= $form->field($model, 'Time') ?>

    <?= $form->field($model, 'Title') ?>

    <?= $form->field($model, 'Title1') ?>

    <?php // echo $form->field($model, 'Lang') ?>

    <?php // echo $form->field($model, 'LangEx') ?>

    <?php // echo $form->field($model, 'SrcLang') ?>

    <?php // echo $form->field($model, 'FileType') ?>

    <?php // echo $form->field($model, 'Encoding') ?>

    <?php // echo $form->field($model, 'Year') ?>

    <?php // echo $form->field($model, 'Deleted') ?>

    <?php // echo $form->field($model, 'Ver') ?>

    <?php // echo $form->field($model, 'FileAuthor') ?>

    <?php // echo $form->field($model, 'N') ?>

    <?php // echo $form->field($model, 'keywords') ?>

    <?php // echo $form->field($model, 'md5') ?>

    <?php // echo $form->field($model, 'Modified') ?>

    <?php // echo $form->field($model, 'pmd5') ?>

    <?php // echo $form->field($model, 'InfoCode') ?>

    <?php // echo $form->field($model, 'Pages') ?>

    <?php // echo $form->field($model, 'Chars') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
