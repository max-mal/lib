<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\core\models\Libbook */

$this->title = 'Update Libbook: ' . $model->Title;
$this->params['breadcrumbs'][] = ['label' => 'Libbooks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Title, 'url' => ['view', 'id' => $model->BookId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="libbook-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
