<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

$root = dirname(__DIR__);

require($root . '/vendor/autoload.php');
require($root . '/vendor/yiisoft/yii2/Yii.php');
require($root . '/configs/bootstrap.php');
require($root . '/configs/frontend/bootstrap.php');
require($root . '/platform/Project.php');


$project = new \platform\Project('frontend');
$project->run();
