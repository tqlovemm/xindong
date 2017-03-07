<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/5
 * Time: 13:22
 */
use yii\helpers\Url;
$this->title = "验证失败";
$rand_url = \yii\myhelper\AccessToken::antiBlocking();
$this->registerCss('
    .container-fluid{padding:0;margin:0}
    .outer{background-color:#fff;}
    #mysreach{
        margin:10px auto 0px;
        color: #F6B944;
        font-size:16px;
        border-bottom:1px solid #F2F1F6;
        padding:20px 0;
        }
    .result{margin-bottom:20px;}
    .kefu{padding:20px 0;}
');

?>
<div class="wrap">
    <div class="container-fluid">
        <div class="center-block" style="background-color: black;line-height: 35px;">
            <div>
                <a href="javascript:history.go(-1)" style="color: #fff;padding-left: 10px;">返回</a>
                <a href="/" style="position: absolute;color: #fff;right: 10px;">首页</a>
            </div>
        </div>
    </div>
</div>
<div class="outer">
    <div class="text-center" id="mysreach">
        <div class="result">
            <img src="/images/check/unrecognized.png" width="60px;">
            <span style="font-weight: bold;">验证失败</span>
        </div>
        <div style="padding: 0 10px;">经系统验证，此客服号不存在，可能是诈骗号！</div>
    </div>
    <div class="kefu text-center">
        <h5>请点击 <a href="<?=Url::toRoute(['/contact','url_contact'=>$rand_url])?>" style="color: #00a65a">联系客服</a>，重新添加客服微信！</h5>

    </div>
</div>