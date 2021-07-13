<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\core\models\Libavtor */

$this->title = 'Create Libavtor';
$this->params['breadcrumbs'][] = ['label' => 'Libavtors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libavtor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
