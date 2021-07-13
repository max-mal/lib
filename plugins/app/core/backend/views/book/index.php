<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\core\models\LibbookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Libbooks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libbook-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Libbook', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'BookId',
            'Title',
            'Lang',
            //'LangEx',
            //'SrcLang',
            //'FileType',
            //'Encoding',
            'Year',
            //'Deleted',
            //'Ver',
            //'FileAuthor',
            //'N',
            //'keywords',
            //'md5',
            //'Modified',
            //'pmd5',
            //'InfoCode',
            //'Pages',
            //'Chars',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
