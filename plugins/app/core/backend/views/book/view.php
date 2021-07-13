<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\core\models\Libbook */

$this->title = $model->Title;
$this->params['breadcrumbs'][] = ['label' => 'Libbooks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="libbook-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->BookId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->BookId], [
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
            'FileSize',
            'Time',
            'Title',
            'Title1',
            'Lang',
            'LangEx',
            'SrcLang',
            'FileType',
            'Encoding',
            'Year',
            'Deleted',
            'Ver',
            'FileAuthor',
            'N',
            'keywords',
            'md5',
            'Modified',
            'pmd5',
            'InfoCode',
            'Pages',
            'Chars',
        ],
    ]) ?>

</div>
