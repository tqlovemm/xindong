<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>十三平台</b>后台管理系统</a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg" style="font-size: 14px;padding: 0 0 15px 0;">为保障账号安全，每次退出或关闭浏览器都需要重新登录，请各位管理员务必记住自己的密码，如果经常使用请不要随便关闭浏览器</p>
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?= $form->field($model, 'username', [
                'inputOptions' => [
                    'placeholder' => $model->getAttributeLabel('username'),
                ]
            ])->label(false); ?>

            <?= $form->field($model, 'password', [
                'inputOptions' => [
                    'placeholder' => $model->getAttributeLabel('password'),
                ]
            ])->passwordInput()->label(false); ?>
            <div class="row">
                <div class="col-xs-12">
                    <?= Html::submitButton('登录', ['class' => 'btn btn-primary pull-right', 'name' => 'login-button']) ?>
                </div><!-- /.col -->
            </div>
        <?php ActiveForm::end(); ?>
    </div><!-- /.login-box-body -->
</div>
