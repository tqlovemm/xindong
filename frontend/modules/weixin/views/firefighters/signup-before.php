<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = '注册验证';
/* @var $this yii\web\View */
/* @var $model frontend\modules\weixin\models\UserWeichat */
/* @var $form ActiveForm */
?>
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
<div class="weicaht_login" style="padding: 10px;background-color: #fff;margin-top: 10px;">
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'number')->textInput(['placeholder'=>'您在十三平台的会员编号'])->label('平台编号') ?>
        <?= $form->field($model, 'address')->dropDownList($area,['prompt'=>'请选择入会时填写的地址'])->label('入会地区') ?>
        <div class="weui_btn_area">
            <?= Html::submitButton('进入注册', ['class' => 'weui_btn weui_btn_primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- weicaht_login -->

<!--<div class="weui_panel weui_panel_access">
    <div class="weui_panel_bd">
        <div class="weui_media_box weui_media_text">
            <h4 class="weui_media_title">为什么要微信认证？</h4>
            <p class="weui_media_desc">微信认证后，您在平台的觅约报名，平台将通过微信公众号方便快捷及时的推送到您的微信上。</p>
        </div>
    </div>
</div>
<div class="weui_panel weui_panel_access">
    <div class="weui_panel_bd">
        <div class="weui_media_box weui_media_text">
            <h4 class="weui_media_title">每次觅约都要微信认证吗？</h4>
            <p class="weui_media_desc">微信认证只需要一次，永久有效，如果您想取消认证可以联系客服。</p>
        </div>
    </div>
</div>-->
