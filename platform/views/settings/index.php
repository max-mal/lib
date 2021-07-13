<?php
use yii\helpers\Html;
use platform\widgets\Card;

$this->title = 'Настройки';

$settings = Yii::$app->pluginManager->getSettings();

?>

<?= Html::beginForm(['index'], 'POST'); ?>
    
    <?php foreach ($settings as $key => $settingsArray) :?>
        <?php
        if (!count($settingsArray)) {
            continue;
        }
        $pluginClass = "\\" . str_replace('/', '\\', $key) . "\\Plugin";
        $plugin = new $pluginClass;
        ?>
        <h4><?=$plugin->getName()?></h4>
        <?php foreach ($settingsArray as $setting) :?>
            <?php Card::begin();?>
                <?php foreach ($setting['items'] as $name => $item) : ?>
                    <div class="form-group">
                        <label><?=$item['label']?></label>
                        <?php
                            $method = isset($item['type'])? $item['type']: 'textInput';
                        ?>
                        <?= Html::$method($key . '__' . $name, Yii::$app->settings->get($key, $name), ['class' => 'form-control']) ?>
                    </div>
                <?php endforeach;?>
                <button class="btn btn-primary" type="submit">Обновить</button>
            <?php Card::end();?>
        <?php endforeach;?>
    <?php endforeach;?>

<?= Html::endForm(); ?>