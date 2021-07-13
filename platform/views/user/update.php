<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model amylabs\user\models\User */

$this->title = 'Изменить пользователя ' . Html::encode($model->username);

$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Html::encode($model->username), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>

<?= $this->render('_update_form', ['model' => $model]);
