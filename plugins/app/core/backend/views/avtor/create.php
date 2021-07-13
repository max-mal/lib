<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\core\models\Libavtorname */

$this->title = 'Create Libavtorname';
$this->params['breadcrumbs'][] = ['label' => 'Libavtornames', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libavtorname-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
