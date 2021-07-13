<?php
use yupe\project\Project;
use yupe\helpers\ArrayHelper;
use yupe\helpers\FileHelper;

$root = dirname(__DIR__);

require($root . '/vendor/autoload.php');
require($root . '/vendor/yupe/yupe2-platform/Yii.php');
require($root . '/configs/bootstrap.php');
require($root . '/configs/frontend/bootstrap.php');

$config = ArrayHelper::merge(
    FileHelper::requireFile($root . '/configs/project.php'),
    FileHelper::requireFile($root . '/configs/project-local.php')
);

$project = new Project($config);
$project->run('frontend');
