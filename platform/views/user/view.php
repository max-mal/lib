<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use platform\widgets\Card;

/* @var $this yii\web\View */
/* @var $model amylabs\user\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Card::begin() ?>
<?= DetailView::widget(
    [
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',

            'profile.first_name',
            'profile.last_name',
            'profile.middle_name',
            'profile.phone',
            
            'status:boolean',
            
            'created_at:datetime',
            'last_login:datetime',
        ],
    ]
) ?>
<?php Card::end();
