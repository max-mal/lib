<?php

namespace app\impulse\components;

use app\impulse\models\Log;
use yii\base\Component;
use yii\helpers\ArrayHelper;

class Impulse extends Component
{
    const LEVEL_ERROR = 1;
    const LEVEL_WARNING = 2;
    const LEVEL_INFO = 4;
    const LEVEL_TRACE = 8;

    public function air($category = null, $message = null, $level = self::LEVEL_INFO)
    {
        if (!$category && !$message) {
            return false;
        }

        $log = new Log();
        $log->level = $level;
        $log->category = $category;
        $log->message = $message;

        if (\Yii::$app->has('user')) {
            $log->user_id = \Yii::$app->user->id;
        }

        if (\Yii::$app instanceof \yii\console\Application) {

        }else{
            $log->ip = \Yii::$app->request->userIP;
            $log->url = \Yii::$app->request->referrer;
        }

        return $log->save();
    }
}
