<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\core\models\Libavtorname */

$this->title = $model->AvtorId;
$this->params['breadcrumbs'][] = ['label' => 'Libavtornames', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="libavtorname-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->AvtorId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->AvtorId], [
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
            'AvtorId',
            'FirstName',
            'MiddleName',
            'LastName',
            'NickName',
            'uid',
            'Email:email',
            'Homepage',
            'Gender',
            'MasterId',
        ],
    ]) ?>

</div>
