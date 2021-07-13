<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\core\models\LibavtornameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Libavtornames';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libavtorname-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Libavtorname', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'AvtorId',
            'FirstName',
            'MiddleName',
            'LastName',
            'NickName',
            //'uid',
            //'Email:email',
            //'Homepage',
            //'Gender',
            //'MasterId',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
