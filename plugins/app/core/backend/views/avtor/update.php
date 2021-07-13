<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\core\models\Libavtorname */

$this->title = 'Update Libavtorname: ' . $model->AvtorId;
$this->params['breadcrumbs'][] = ['label' => 'Libavtornames', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->AvtorId, 'url' => ['view', 'id' => $model->AvtorId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="libavtorname-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
