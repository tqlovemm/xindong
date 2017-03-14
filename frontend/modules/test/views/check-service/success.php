<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/5
 * Time: 13:22
 */
$this->title = "验证成功";
$pre_url = Yii::$app->params['threadimg'];
$this->registerCss('
    .container-fluid{padding:0;margin:0}
    .outer{background-color:#fff;}
    #mysreach{
        margin:10px auto 0px;
        color: #78D117;
        font-size:16px;
        border-bottom:1px solid #F2F1F6;
        padding-bottom:15px;
        padding-top:15px;
        }
    .result{margin-bottom:15px;}
    #avatar{width:60px;height:60px;border-radius:5px;}

');
?>
<div class="wrap">
    <div class="container-fluid">
        <div class="center-block" style="background-color: black;height: 35px;line-height: 35px;">
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
            <img src="/images/check/recognized.png" style="width: 60px;">
            <span style="font-weight: bold;">验证成功</span>
        </div>
        <div style="padding: 0 10px;">经系统验证，此客服号为平台官方客服号，请放心使用！</div>
    </div>
    <div class="row" style="margin: 0 auto;padding:15px 0;">
        <div class="col-xs-3" style="padding-right: 0;">
            <img class="img-responsive" id="avatar" src="<?=$pre_url.$model['avatar']?>">
        </div>
        <div class="col-xs-9" style="font-size: 16px;padding-left:15px;">
            <h4 style="margin-top: 8px;"><?=$model['nickname']?></h4>
            <h5>微信号：<?=$model['number']?></h5>
        </div>
    </div>
</div>