<?php

namespace platform\controllers;

use Yii;

class LicenseController extends \yii\web\Controller
{
    
    public function actionIndex()
    {
        $composerPlugins = shell_exec("cd " .Yii::getAlias('@project') . "; ./composer.phar show -f json");
        $plugins = json_decode($composerPlugins, true);

        foreach ($plugins['installed'] as $index => $plugin) {
            $licenseFile = $this->findLicenseFile($plugin);

            if (!$licenseFile) {
                $firstLine = 'Лицензия не найдена';
                $plugins['installed'][$index]['license'] = $firstLine;
                $plugins['installed'][$index]['licenseFile'] = $licenseFile;
                continue;
            }
            $f = fopen($licenseFile, 'r');
            $firstLine = fgets($f);
            fclose($f);

            $plugins['installed'][$index]['license'] = $firstLine;
            $plugins['installed'][$index]['licenseFile'] = $licenseFile;
        }

        return $this->render('index', ['plugins' => $plugins]);
    }

    private function findLicenseFile($plugin)
    {
        $possibleNames = ['LICENSE', 'license', 'license.txt', 'LICENSE.txt', 'LICENSE.md', 'license.md', 'License.md', 'License.txt', 'License'];
        $licenseFile = null;

        foreach ($possibleNames as $name) {
            $file = Yii::getAlias('@vendor') . '/' . $plugin['name'] . '/' . $name;
            if (file_exists($file)) {
                $licenseFile = $file;
                break;
            }
        }

        return $licenseFile;
    }

    public function actionLicenseFile($plugin)
    {
        $composerPlugins = shell_exec("cd " .Yii::getAlias('@project') . "; ./composer.phar show -f json");
        $plugins = json_decode($composerPlugins, true);

        foreach ($plugins['installed'] as $index => $record) {
            if ($record['name'] !== $plugin) {
                continue;
            }

            $licenseFile = $this->findLicenseFile($record);
            if (!$licenseFile) {
                return 'Файл лицензии не найден';
            }

            return $this->render('license', ['content' => '<pre>' . file_get_contents($licenseFile) .'</pre>']);
        }
    }
}
