<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use platform\widgets\Card;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\impulse\backend\models\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Air';
$this->params['breadcrumbs'][] = $this->title;

\app\impulse\backend\assets\ImpulseAsset::register($this);
?>
<style>
    .grid-view tbody a {
        border-bottom: dashed 1px;
    }
</style>

<div class="log-index">
    <?php Card::begin([
        'title' => 'Список',
        'tools' =>
            Html::beginForm(['/impulse/air/index'], 'get', ['class' => 'js-filter-form']) .
            '<div class="input-group">' .
            Html::activeTextInput($searchModel, 'created_at', ['class' => 'form-control js-daterange', 'placeholder' => 'Дата']) .
            '<span class="input-group-addon"><i class="icon-calendar"></i></span>' .
            '</div>' .
            Html::endForm(),
    ]); ?>

    <?php Pjax::begin([
        'formSelector' => '.js-filter-form',
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'user_id',
                'format' => 'raw',
                //'filter' => \amylabs\user\models\User::getList(),
                'value' => function (\app\impulse\models\Log $data) {
                    if (!$data->user_id) {
                        return 'Гость';
                    }

                    return Html::a($data->user->username, ['/impulse/air/index', 'LogSearch[user_id]' => $data->user_id]);
                },
                'options' => [
                    'style' => 'width: 250px;',
                ],
            ],
            [
                'attribute' => 'level',
                'format' => 'raw',
                'filter' => \app\impulse\models\Log::getLevelsList(),
                'value' => function (\app\impulse\models\Log $data) {
                    if (!$data->level) {
                        return '';
                    }

                    return Html::a($data->getLevelTitle(), ['/impulse/air/index', 'LogSearch[level]' => $data->level]);
                },
                'options' => [
                    'style' => 'width: 150px;',
                ],
            ],
            [
                'attribute' => 'category',
                'format' => 'raw',
                'filter' => \app\impulse\models\Log::getCategoriesList(),
                'value' => function (\app\impulse\models\Log $data) {
                    if (!$data->category) {
                        return '';
                    }

                    return Html::a($data->category, ['/impulse/air/index', 'LogSearch[category]' => $data->category]);
                },
                'options' => [
                    'style' => 'width: 200px;',
                ],
            ],
            'message:ntext',
            [
                'attribute' => 'url',
                'format' => 'raw',
                'value' => function (\app\impulse\models\Log $data) {
                    if (!$data->url) {
                        return '';
                    }

                    return Html::a($data->url, $data->url, ['data-pjax' => 0, 'target' => '_blank']);
                },
            ],
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'filter' => false,
                'options' => [
                    'style' => 'width: 200px;',
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    <?php Card::end(); ?>
</div>

<?php $this->registerJs(<<<'JS'
moment.locale("ru");
var refreshDateRange = function (start, end) {
    $('.js-daterange span').html(start.format('LL') + ' - ' + end.format('LL'));
};

refreshDateRange(moment().startOf('month'), moment().endOf('month'));

var ranges = {
    'Сегодня': [moment(), moment()],
    'Последние 7 дней': [moment().subtract(6, 'days'), moment()],
    'Этот месяц': [moment().startOf('month'), moment().endOf('month')],
    'Прошлый месяц': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
};

$('.js-daterange')
    .daterangepicker({
            autoApply: true,
            autoUpdateInput: false,
            applyClass: 'bg-slate-600',
            opens: 'left',
            "locale": {
                "format": "DD.MM.YYYY",
                "separator": " - ",
                "applyLabel": "Применить",
                "cancelLabel": "Отменить",
                "fromLabel": "С",
                "toLabel": "До",
                "customRangeLabel": "Свой интервал",
                "startLabel": 'Начальная дата:',
                "endLabel": 'Конечная дата:',
                "daysOfWeek": [
                    "Вс",
                    "Пн",
                    "Вт",
                    "Ср",
                    "Чт",
                    "Пт",
                    "Сб"
                ],
                "monthNames": [
                    "Январь",
                    "Февраль",
                    "Март",
                    "Апрель",
                    "Мая",
                    "Июнь",
                    "Июль",
                    "Август",
                    "Сентябрь",
                    "Октябрь",
                    "Ноябрь",
                    "Декабрь"
                ],
                "firstDay": 1
            },
            ranges: ranges
        },
        refreshDateRange
    )
    .off('apply.daterangepicker')
    .on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    })
    .on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD.MM.YYYY') + ' - ' + picker.endDate.format('DD.MM.YYYY'));
        $('.js-filter-form').submit();
    });
            
JS
) ?>
