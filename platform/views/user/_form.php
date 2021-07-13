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
                'Создать',
                ['class' => 'btn btn-primary']
            ),
        ]); ?>
        <?= $form->field($model, 'username')->textInput() ?>
        <?= $form->field($model, 'email')->textInput() ?>
        <?= $form->field($model, 'plainPassword')->passwordInput() ?>                
        <?php Card::end() ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
