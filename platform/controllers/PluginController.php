<?php

namespace platform\controllers;

use Yii;
use yii\console\Controller;

class PluginController extends Controller
{
    
    public function actionInstallAll()
    {
        $plugins = Yii::$app->pluginManager->getList();


        $this->migrate([
            'migrationPath' => '@yii/log/migrations'
        ]);

        $this->migrate([
            'migrationPath' => '@vendor/yii2mod/yii2-user/migrations'
        ]);

        $this->migrate([
            'migrationPath' => '@yii/rbac/migrations'
        ]);

        $this->migrate([
            'migrationPath' => '@platform/migrations'
        ]);

        $this->migrate();

        foreach ($plugins as $pluginName => $state) {
            echo "Migrating $pluginName..." . PHP_EOL;
            if (!file_exists(Yii::getAlias('@project') . '/plugins/' . $pluginName . '/install/migrations')) {
                echo "  Skipping, migration directory doesnt exists" . PHP_EOL;
                continue;
            }
            $this->migrate([
                "migrationPath" => '@' . $pluginName . '/install/migrations',
            ]);
        }
    }

    private function migrate($params = [])
    {
        $code = Yii::$app->runAction('migrate', array_merge([
            'interactive' => 0,
        ], $params));

        if ($code == 0) {
            echo "  Done" . PHP_EOL;
        } else {
            throw new \Exception("Migration failed!");
        }
    }

    public function actionRate()
    {
        $count = 0;
        foreach (\app\core\models\Libbook::find()->each(10) as $book) {
            $rate = \app\core\models\Librate::find()->where(['BookId' => $book->BookId])->sum('Rate');
            $book->Rate = $rate;
            $book->save();
            $count++;
            echo $count . PHP_EOL;
        }
    }
}
