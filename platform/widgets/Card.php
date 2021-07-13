<?php

namespace platform\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class Card extends Widget
{
    
    public $title = '';
    public $footer = '';
    public $tools = '';

    public function init()
    {
        parent::init();
        ob_start();
    }

    public function run()
    {
        $content = ob_get_clean();
        $cardText = Html::tag('div', $content, ['class' => 'card-text']);
        $cardTitle = $this->title? Html::tag('div', Html::tag('h6', $this->title, ['class' => 'm-0 font-weight-bold text-primary']), ['class' => 'card-header py-3 mb-2']): '';

        $card = Html::tag(
            'div',
            Html::tag('div', ($cardTitle . $this->tools . $cardText . $this->footer), ['class' => 'card-body']),
            ['class' => 'card shadow mb-4']
        );

        return $card;
    }
}
