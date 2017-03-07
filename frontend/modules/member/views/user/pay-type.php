<?php

$this->title="支付类型";
$this->registerCss("

.list-group-item {
    position: relative;
    display: block;
    padding: 10px 15px;
    margin-bottom: -1px;

    border-radius:1px !important;
    border: 1px solid #f2f2f2;
}
.list-group-item span{padding:0}
.list-group-item img{width: 30px;}

");
?>
<div class="row member-center">
    <header>
        <div class="header">
            <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
            <h2 style="margin:0;"><?=$this->title?></h2>
            <a id="list_01" href="/member/setting" class="glyphicon glyphicon-cog"  style="right:3%;top:0;font-size:20px;line-height: 44px;position: absolute;"></a>
        </div>
    </header>
</div>
<div class="row" style="padding:20px 10px 0;background-color: #fff;color:#b5b5b5;">为了确保您的充值成功，充值之后请务必联系微信私人客服核实，给您带来不便请谅解。</div>
<div class="row" style="padding:20px 10px;background-color: #fff;">
    <ul class="list-group">
        <li class="list-group-item clearfix">
            <a href="coin-recharge-alipay?id=<?=$id?>">
                <span class="col-xs-2"><img src="<?=Yii::getAlias('@web')?>/images/pay/alipay.png"></span>
                <span class="col-xs-4" style="font-size: 16px;line-height: 30px;">支付宝支付</span>
                <span class="col-xs-4" style="font-size: 12px;">网页端请使用支付宝支付</span>
                <span class="col-xs-1 col-xs-offset-1" style="font-size: 20px;line-height: 30px;color:#ddd;"> <i class="glyphicon glyphicon-menu-right"></i> </span>
            </a>
        </li>
        <br>
        <li class="list-group-item clearfix">
            <a href="http://13loveme.com/member/user/jiecao-recharge-wxpay?id=<?=$id?>">
                <span class="col-xs-2"><img src="<?=Yii::getAlias('@web')?>/images/pay/weipay.png"></span>
                <span class="col-xs-4" style="font-size: 16px;line-height: 30px;">微信支付</span>
                <span class="col-xs-4" style="font-size: 12px;">微信端请使用微信支付</span>
                <span class="col-xs-1 col-xs-offset-1" style="font-size: 20px;line-height: 30px;color:#ddd;"> <i class="glyphicon glyphicon-menu-right"></i> </span>
            </a>
        </li>

    </ul>
</div>
<?php
    if(Yii::$app->user->id==10001){

        echo $this->render("../common/contact");
    }
?>