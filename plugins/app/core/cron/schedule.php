<?php

use app\core\rbac\ErpRights;
use app\user\models\Profile;
use app\core\utils\TimeReport;
use app\core\models\Project;
use app\planfix\helpers\ApiHelper as PlanfixApiHelper;

/**
 * @var \omnilight\scheduling\Schedule $schedule
 */

// Place here all of your cron jobs

date_default_timezone_set('Europe/Moscow');
