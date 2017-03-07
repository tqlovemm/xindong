<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\web\View;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = '注册';
$this->registerCss('
    footer{display:none;}
    .form-signup {padding: 15px;margin: 0 auto;}
    .form-signup .form-signup-heading,.form-signup .checkbox {margin-bottom: 10px;}
    .form-signup .checkbox {font-weight: normal;}
    .form-signup .form-control {position: relative;height: auto;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px;font-size: 16px;}
    .form-signup .form-control:focus {z-index: 2;}
    .form-signup input[type="email"] {margin-bottom: -1px;border-bottom-right-radius: 0;border-bottom-left-radius: 0;}
    .form-signup input[type="password"] {margin-bottom: 10px;border-top-left-radius: 0;border-top-right-radius: 0;}
    .field-signupform-smscode{width:60%;float:left;margin-bottom:0;}
    .field-signupform-smscode p{margin-bottom:0;}
    #second{float:right;width:36%;}
');
?>
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<div class="container">

    <div class="row center-block" style="padding: 20px 0;max-width: 400px;">
        <div class="" style="background-color: #fff;padding: 10px 20px;">
            <?php $form = ActiveForm::begin(); ?>
            <h3 style="color: #E83F78;margin-top: 10px;margin-bottom: 20px;">注册</h3>
            <div class="form-group has-feedback">
                <?= $form->field($model, 'email', [
                    'template' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>{input}</div>{error}',
                    'inputOptions' => [
                        'placeholder' => $model->getAttributeLabel('email'),
                    ],
                ])->label(false);?>
            </div>
            <div class="form-group has-feedback">
                <?= $form->field($model, 'password', [
                    'template' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>{input}</div>{error}',
                    'inputOptions' => [
                        'placeholder' => $model->getAttributeLabel('password'),
                    ],
                ])->passwordInput()->label(false);?>
            </div>
            <div class="form-group has-feedback">
                <?= $form->field($model, 'password2', [
                    'template' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>{input}</div>{error}',
                    'inputOptions' => [
                        'placeholder' => $model->getAttributeLabel('password2'),
                    ],
                ])->passwordInput()->label(false);?>
            </div>
            <p>注册即视为同意<a style='color:red;' href='/attention/disclaimers'>《用户使用协议》</a></p>
            <div class="form-group">
                <?= Html::submitButton('注册', ['class' => 'btn btn-primary', 'id'=>'form-signup', 'style'=>'border-color:#E83F78;background-color:#E83F78;width:100%;padding: 5px 0;font-size:20px;','name' => 'login-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script>
    window.onload=function(){

        $("#form-signup").click(function (){
            isPhoneNum();
        });
    };
    function isPhoneNum(){
        if($('#signupform-email').val()==''){
            alert('请输入邮箱号！');
            $("#signupform-email").focus();
            return false;
        }else{
            return true;
        }
    }
</script>