<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/platform/site/password-reset', 'token' => $user->password_reset_token]);
?>

Здравствуйте, <?php echo Html::encode($user->username) ?><br>

Для сброса пароля, перейдите по ссылке. ><br><br>

Если вы не запрашивали сброс пароля, просто игнорируйте это письмо.

<?php echo Html::a(Html::encode($resetLink), $resetLink) ?>