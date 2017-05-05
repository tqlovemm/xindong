<?php
$flag = Yii::$app->request->get('flag');
$this->title = "十三平台入会申请表";
$this->registerCss('
 .weui_panel{margin-top:0 !important;}
 .container-fluid{padding:0;}
');
?>
<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
<div class="weui_panel weui_panel_access">
    <div class="weui_panel_hd">您的资料已审核通过，请选择注册方式</div>
    <div class="weui_panel_bd">
        <a href="/site/register?flag=<?=$flag?>" class="weui_media_box weui_media_appmsg">
            <div class="weui_media_hd">
                <span style="font-size: 60px;color:#3cc51f;" class="glyphicon glyphicon-phone weui_media_appmsg_thumb"></span>
            </div>
            <div class="weui_media_bd">
                <h4 class="weui_media_title">手机注册</h4>
                <p class="weui_media_desc">正常中国境内手机请使用手机注册。</p>
            </div>
        </a>
        <a href="/site/register-email?flag=<?=$flag?>" class="weui_media_box weui_media_appmsg">
            <div class="weui_media_hd">
               <span style="font-size: 60px;color:#3cc51f;" class="glyphicon glyphicon-envelope weui_media_appmsg_thumb"></span>
            </div>
            <div class="weui_media_bd">
                <h4 class="weui_media_title">邮箱注册</h4>
                <p class="weui_media_desc">如果您的手机号码非中国境内，请使用邮箱注册</p>
            </div>
        </a>
    </div>
</div>