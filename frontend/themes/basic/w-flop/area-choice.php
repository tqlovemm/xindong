<?php
use yii\helpers\Url;
if(empty($openid)){
    $openid = Yii::$app->request->get('openid');
}

$this->title = "地区";
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
<header>
    <div class="header">
        <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/icon/iconfont-fanhui2(1).png"></span></a>
        <h2><?=$this->title?></h2>
    </div>
</header>
<div class="flop-location">
    <div class="system">
        <h5>定位到的位置</h5>
        <a href="<?=Url::toRoute(['/w-flop/area','openid'=>$openid])?>">
            <div class="marker-area">
                <span style="color:red;" class="glyphicon glyphicon-map-marker"></span>
                <span><?=$area?></span>
            </div>
        </a>
    </div>
    <div class="system">
        <h5>全部</h5>
        <?php foreach($model as $areas):?>
        <a href="<?=Url::toRoute(['/w-flop/area','area'=>$areas,'openid'=>$openid])?>">
            <div class="marker-area">
                <span class="pull-left"><?=$areas?></span>
                <span class="pull-right"><img src="<?=Yii::getAlias('@web')?>/images/icon/iconfont-fanhui(1).png"></span>
            </div>
        </a>
        <?php endforeach;Yii::$app->session->setFlash('skip_teach','skip_teach');?>
    </div>
</div>

