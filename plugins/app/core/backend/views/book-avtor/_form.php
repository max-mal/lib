<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\core\models\Libavtor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="libavtor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'BookId')->textInput() ?>

    <?= $form->field($model, 'AvtorId')->textInput() ?>

    <?= $form->field($model, 'Pos')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
