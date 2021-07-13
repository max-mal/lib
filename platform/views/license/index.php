<?php
use yii\data\ArrayDataProvider;
use platform\widgets\Card;
use yii\grid\GridView;
use yii\helpers\Html;
use kartik\icons\FontAwesomeAsset;



$this->title = 'Лицензии использованных пакетов';

$provider = new ArrayDataProvider([
    'allModels' => $plugins['installed'],
    'pagination' => [
        'pageSize' => 100,
    ],
    'sort' => [
        'attributes' => ['name'],
    ],
]);
?>


<?php Card::begin(); ?>
    <?=GridView::widget([
        'dataProvider' => $provider,
        'columns' => [
            'name',
            'version',
            'description',
            'license',
            [
                'label' => '',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a('<i class="fa fa-file"></i>', ['license-file', 'plugin' => $model['name']]);
                }
            ]
        ]
    ])?>
<?php Card::end();
