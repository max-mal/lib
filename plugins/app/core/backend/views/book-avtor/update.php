<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\core\models\Libavtor */

$this->title = 'Update Libavtor: ' . $model->BookId;
$this->params['breadcrumbs'][] = ['label' => 'Libavtors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->BookId, 'url' => ['view', 'BookId' => $model->BookId, 'AvtorId' => $model->AvtorId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="libavtor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
