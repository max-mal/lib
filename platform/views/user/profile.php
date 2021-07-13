<?php

use yii\helpers\Html;
use platform\widgets\Card;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model amylabs\user\models\Profile */

$this->title = 'Обновить профиль';

$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user->username, 'url' => ['view', 'id' => $model->user->id]];
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="row">
    <div class="col-sm-12">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?php Card::begin([
            'footer' => Html::submitButton('Сохранить', ['class' => 'btn btn-primary']),
        ]); ?>
        <input class="formControl" type="file" name="Profile[uploadedAvatar]">
        <?= $form->field($model, 'last_name')->textInput() ?>
        <?= $form->field($model, 'first_name')->textInput() ?>
        <?= $form->field($model, 'middle_name')->textInput() ?>        
        <?= $form->field($user, 'email')->textInput() ?>
        <?php Card::end() ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
