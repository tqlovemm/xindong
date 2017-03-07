<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\myhelper\Random;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = '登录';

$this->registerCss('
    header{width:100%;height:44px;background-color:#E83F78;position: relative;z-index: 10;margin-bottom:15px;}
    header a{color:white;position: absolute;}
    header h2{color: #fff;font-size: 16px;font-weight: normal;height:44px;text-align: center;line-height:44px;font-weight: bold;margin-top: 0;}
    header span{display: block;height: 35px;text-indent: 17px;width: 50px;color: #FFF;font-size: 14px;padding-top: 8px;margin-left: -10px;}
    header span img{width: 25px;}

    .form-signin {

      padding: 15px;
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
<header>
    <div class="header">
        <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
        <h2><?=$this->title?></h2>
    </div>
</header>
<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => [
        'class' => 'form-signin'
    ]
]); ?>

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
    <?= '如果你忘记密码：' . Html::a('重置密码', ['site/request-password-reset']) ?>.
</div>
<div class="form-group">
    <?= Html::submitButton('登录', ['class' => 'btn btn-primary',  'style'=>'border-color:#E83F78;background-color:#E83F78;width:100%;padding: 5px 0;font-size:20px;','name' => 'login-button']) ?>
</div>

<div class="row weixin">
    <div class="col-md-6">
        <h4 class="text-gray text-center" style='font-family: 仿宋;font-weight: bold;'>尚未入会的男生请加微信：shisanyp13</h4>
        <img class="img-responsive center-block" src="<?=Yii::getAlias('@web')?>/images/weixin/2.jpg">
    </div>
    <div class="col-md-6">
        <h4 class="text-gray text-center" style='font-family: 仿宋;font-weight: bold;'>尚未入会的女生请加微信：jiecao13</h4>
        <img class="img-responsive center-block" src="<?=Yii::getAlias('@web')?>/images/weixin/1.jpg">
    </div>


</div>


<?php ActiveForm::end(); ?>


