<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\myhelper\Random;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = '登录';

$this->registerCss('

    footer{display:none;}
    .form-signin {

      margin: 0 auto;
    }
    .logo img {
      max-width: 100%;
    }
    .form-signin .form-signin-heading,
    .form-signin .checkbox {
      margin-bottom: 10px;
    }
    .form-signin .checkbox {
      font-weight: normal;
    }
    .form-signin .form-control {
      position: relative;
      height: auto;
      -webkit-box-sizing: border-box;
         -moz-box-sizing: border-box;
              box-sizing: border-box;
      padding: 10px;
      font-size: 16px;
    }
    .form-signin .form-control:focus {
      z-index: 2;
    }
    .form-signin input[type="text"] ,
    .form-signin input[type="password"] {

      border-top-left-radius: 0;
      border-top-right-radius: 0;
    }
    @media (max-width:768px){
        .weixin h4{font-size:24px;}

    }
');
?>
<div class="container">

<div class="row center-block" style="padding: 20px 0;max-width: 400px;">
    <div class="" style="background-color: #fff;padding: 10px 20px;">
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => [
                'class' => 'form-signin'
            ]
        ]); ?>
        <h3 style="color: #E83F78;margin-top: 10px;margin-bottom: 20px;">登录</h3>
        <?= $form->field($model, 'username', [
            'template' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>{input}</div>{error}',
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('username'),
            ],
        ])->label(false);
        ?>
        <?= $form->field($model, 'password', [
            'template' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>{input}</div>{error}',
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('password'),
            ],
        ])->passwordInput()->label(false);
        ?>
        <?= $form->field($model, 'rememberMe')->checkbox() ?>
        <div style="color:#999;margin:1em 0">
            <span><?= '如果你忘记密码：' . Html::a('邮箱修改', ['site/request-password-reset']) ?></span>
            <span style="margin-left: 10px;"><?= Html::a('短信修改', 'site/mobile-password-reset') ?></span>
        </div>
        <div class="form-group">
            <?= Html::submitButton('登录', ['class' => 'btn btn-primary',  'style'=>'border-color:#E83F78;background-color:#E83F78;width:100%;padding: 5px 0;font-size:20px;','name' => 'login-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
    <div class="row">
        <a href="/contact" class="center-block" style="width: 240px;padding: 10px 20px;font-size: 20px;text-align: center;color:#E83F78;border: 1px solid #E83F78;border-radius: 50px;">尚未入会的点这里</a>
    </div>
</div>

