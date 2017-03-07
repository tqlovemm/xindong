<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model frontend\models\WechatDatingSignup */
/* @var $form ActiveForm */
$this->title = "报名";
$this->registerCss("

    .dating__signup{max-width:768px;margin:0 auto;}
    header{width:100%;height:44px;background: #E83F78;position: relative;z-index: 10;margin-bottom:15px;}
    header a{color:white;position: absolute;}
    header h2{color: #fff;font-size: 16px;font-weight: normal;height:44px;text-align: center;line-height:44px;font-weight: bold;margin-top: 0;}
    header span{display: block;height: 35px;text-indent: 17px;width: 50px;color: #FFF;font-size: 14px;padding-top: 8px;margin-left: -10px;}
    header span img{width: 25px;}
    .dating_signup{padding:0 15px;}

");
?>
<div class="row">

    <div class="dating__signup">
        <header>
            <div class="header">
                <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
                <h2><?=$this->title?></h2>
            </div>
        </header>
        <div class="dating_signup">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'number')->textInput(['placeholder'=>'请填写十三会员编号'])->label(false) ?>
            <?= $form->field($model,'like_id')->hiddenInput(['value'=>$user_info['like_id']])->label(false)?>
            <?= $form->field($model,'openid')->hiddenInput(['value'=>$user_info['openid']])->label(false)?>

            <div class="form-group">
                <?= Html::submitButton('报名', ['class' => 'btn btn-primary',
                    'style'=>'border-color:#E83F78;background-color:#E83F78;width:100%;padding: 5px 0;font-size:20px;',]) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div><!-- _dating_signup -->
    </div>

</div>
