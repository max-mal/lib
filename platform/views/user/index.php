<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php \platform\widgets\Card::begin([
    'title' => 'Пользователи',
    'tools' => Html::a(
        '<i class="fa fa-plus-circle"></i> Создать',
        ['create'],
        ['class' => 'btn btn-success']
    ),
]); ?>

<?= GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'id',
                'value' => function ($user) {
                    return Html::a($user->id, ['/user/user/update', 'id' => $user->id]);
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'username',
                'value' => function ($user) {
                    return Html::a($user->username, ['/user/user/update', 'id' => $user->id]);
                },
                'format' => 'html'
            ],
            'email:email',
            'profile.first_name',
            'profile.last_name',
            'profile.phone',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "<div class='btn-group'> {profile} {roles} {view} {update} {delete}</div>",
                'buttons' => [
                    'profile' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="fa fa-fw fa-user"></i>',
                            $url,
                            ['class' => 'btn btn-sm btn-default', 'title' => 'Профиль']
                        );
                    },
                    'roles' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="fa fa-list"></i>',
                            ['/rbac/assignment/view', 'id' => $model->id],
                            ['class' => 'btn btn-sm btn-default', 'title' => 'Роли']
                        );
                    },
                ],
            ],
        ],
    ]
); ?>

<?php \platform\widgets\Card::end();
