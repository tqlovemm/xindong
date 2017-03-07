<?php
if(empty($openid)){
    $openid = Yii::$app->request->get('openid');
}
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title=$local."男生档案";
$this->registerCss('

    .navbar,footer,.weibo-share{display:none;}
    header{width:100%;height:44px;background: #F0EFF5;position: relative;z-index: 10;border-bottom:1px solid #D0CACD;}
    header a{color:black;position: absolute;}
    header h2{color: black;font-size: 16px;font-weight: normal;height:44px;text-align: center;line-height:44px;font-weight: bold;margin-top: 0;}
    header span{display: block;height: 35px;text-indent: 17px;width: 50px;color: #FFF;font-size: 14px;padding-top: 8px;margin-left: -10px;}
    header span img{width: 25px;}
    .flop-location{}
    .system{margin-top:30px;}
    .system h5{padding:0 20px;color:gray;font-size:16px;}
    .marker-area:after{content:".";height:0;clear:both;display:block;visibility: hidden;}
    .marker-area{padding:10px 20px;background-color:white;font-size:18px;font-weight:bold;margin-bottom:2px;}
    .marker-area img{width: 25px;}

    .location-border-bottom{border-bottom:1px solid #D0CACD;}

');
?>
<div class="flop-yanzhen-form">

    <header>
        <div class="header">
            <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/icon/iconfont-fanhui2(1).png"></span></a>
            <h2 style="color:gray;">当前位置--<?=$local?>站</h2>

        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <p style="padding:2px;margin-top: 60px;"><strong>获取非本地翻牌密码<br></strong><br><a class="btn btn-primary center-block" style="background-color: #fff;color:#E3326D;border: none;padding:10px 0;box-shadow: 0 0 4px #ddd;" href="/contact">点击联系客服咨询</a></p>
                <?php $form = ActiveForm::begin(); ?>
                <div class="form-group">
                    <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'翻牌密码'])->label(false) ?>
                    <?= Html::submitButton('确定', ['class' => 'btn btn-primary pull-right','style'=>'width:40%;', 'name' => 'login-button']) ?>
                </div>
                <?php ActiveForm::end();Yii::$app->session->setFlash('skip_teach','skip_teach'); ?>
            </div>
        </div>
    </div>
</div>