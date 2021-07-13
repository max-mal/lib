<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Libavtors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libavtor-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Libavtor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'BookId',
            'AvtorId',
            'Pos',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
