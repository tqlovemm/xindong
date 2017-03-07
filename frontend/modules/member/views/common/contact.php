<?php
$this->registerCssFile('@web/js/lightbox/css/lightbox.css');
$this->registerJsFile('@web/js/lightbox/js/lightbox.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);
$this->title="支付类型";
$this->registerCss("
    
    .lightbox .lb-image{z-index:9999999 !important;}
    .lb-nav{z-index:-1;}
");

?>
<!--微信公众号以及联系方式start-->
<div class="row" style="background-color: #fff;margin-top: 10px;padding:10px;text-align: center;">
    <span class="col-xs-4" style="line-height: 27px;font-size: 15px;padding:0;">联系客服</span>
    <a class="col-xs-4" href="/images/weixin/thirteenpingtai.jpg" data-lightbox="image" data-title="微信搜索公众号：心动三十一天" >
        <img style="width: 30px;" alt="客服微信号" src="<?=Yii::getAlias('@web')?>/images/weichat-top.png">
    </a>
    <a class="col-xs-4" href="http://wpa.qq.com/msgrd?v=3&uin=8495167&site=qq&menu=yes" target="_blank" >
        <img style="width: 26px;" src="<?=Yii::getAlias('@web')?>/images/qq-top.png">
    </a>
</div>