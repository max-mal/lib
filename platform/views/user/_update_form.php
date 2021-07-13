<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use platform\widgets\Card;

/* @var $this yii\web\View */
/* @var $model amylabs\user\models\User */
/* @var $form kartik\form\ActiveForm */
?>

<div class="row">
    <div class="col-sm-6">
        <?php $form = ActiveForm::begin(); ?>
        <?php Card::begin([
            'footer' => Html::submitButton(
                $model->getIsNewRecord() ? 'Create user'
                 :  'Update user',
                ['class' => $model->getIsNewRecord() ? 'btn btn-success' : 'btn btn-primary']
            ),
        ]); ?>
        <?= $form->field($model, 'username')->textInput() ?>
        <?= $form->field($model, 'email')->textInput() ?>
        <?= $form->field($model, 'status')->dropDownList(['1' => 'Активен', '0' => 'Заблокирован']) ?>
        <?php Card::end() ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
