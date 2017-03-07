<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->registerCss('
    .navbar-toggle,#w1,.footer{display:none;}
');
?>
<div class="container" style="margin-top: 80px;">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <img class="img-responsive center-block" alt="十三平台logo" src="<?=Yii::getAlias('@web')?>/images/logo1.png" width="100%">
            <p style="padding:2px;margin-top: 20px;"><strong>获取觅约密码<br></strong><br><span style="color:red;">会员：</span>请联系十三爷交友平台或私人客服<br><br><span style="color:red;">非会员：</span><a class="btn btn-default" href="/contact">请点击</a></p>
            <?php $form = ActiveForm::begin(); ?>
            <div class="form-group">
            <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'觅约密码'])->label(false) ?>
            <?= Html::submitButton('确定', ['class' => 'btn btn-primary pull-right','style'=>'width:40%;', 'name' => 'login-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>