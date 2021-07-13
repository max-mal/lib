<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\core\models\Libavtor */

$this->title = $model->BookId;
$this->params['breadcrumbs'][] = ['label' => 'Libavtors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="libavtor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'BookId' => $model->BookId, 'AvtorId' => $model->AvtorId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'BookId' => $model->BookId, 'AvtorId' => $model->AvtorId], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'BookId',
            'AvtorId',
            'Pos',
        ],
    ]) ?>

</div>
