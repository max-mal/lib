<?php
namespace platform;

use Yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    /**
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $locator = Yii::$app;
        $config = [
             'class' => 'yii\swiftmailer\Mailer',
             'transport' => Yii::$app->settings->get('platform', 'smtp-server')? [
                 'class' => 'Swift_SmtpTransport',
                 'host' => Yii::$app->settings->get('platform', 'smtp-server'),  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                 'username' => Yii::$app->settings->get('platform', 'smtp-user'),
                 'password' => Yii::$app->settings->get('platform', 'smtp-password'),
                 'port' => (int)Yii::$app->settings->get('platform', 'smtp-port'), // Port 25 is a very common port too
                 'encryption' => Yii::$app->settings->get('platform', 'smtp-secure'), // It is often used, check your provider or mail server specs
             ] : [],
             'useFileTransport' => Yii::$app->settings->get('platform', 'smtp-debug')? true: false,
             'messageConfig' => [
                'from' => [ Yii::$app->settings->get('platform', 'email-from', 'app@mail.sth') => Yii::$app->settings->get('platform', 'name-from', Yii::$app->name)],
             ],
             'htmlLayout' => '@platform/layouts/mail',
        ];
        
        $locator->set('mailer', $config);

        Yii::$app->params['adminEmail'] = Yii::$app->settings->get('platform', 'email-from', 'app@mail.sth');
    }
}
