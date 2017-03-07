<?php
use yii\helpers\Html;

    $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>

您好: <?= Html::encode($user->username) ?>,

访问以下链接重置您的密码：

<?= Html::a(Html::encode($resetLink), $resetLink) ?>
