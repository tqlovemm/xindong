<?php

$this->title='节操币';
$this->registerCss("


    .jiecao-value{background-color:#fff;padding:10px 20px 20px;}
    .jiecao-recharge{margin-top:10px;}

    .member-jiecao{background-color:#969393;text-align:center;}
    .member-jiecao .col-xs-4 a,.member-jiecao .col-xs-4{color:white;}
    .navbar{margin-bottom:1em;}
    .jiecao-icon{border:1px solid #fff;width:30px;height:30px;text-align:center;line-height:40px;margin:auto;}
    .jiecao-service-title{padding:0 10px;}
    .jiecao-service-content{padding:0px;background-color:white;}
    .jiecao-service-content .col-xs-4{height:100px;border:1px solid #D8D8D8;padding:15px;border-top:none;}
    .service-icon{color:rgba(239, 68, 80, 1);font-size:28px;}
");
$query = \frontend\models\UserData::find()->where(['user_id'=>Yii::$app->user->id])->asArray()->one();
?>
<div class="row member-center">
    <header>
        <div class="header">
            <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
            <h2 style="margin:0;"><?=$this->title?></h2>
            <a id="list_01" href="recharge-record" style="right:3%;top:0;font-size:14px;line-height: 44px;position: absolute;">明细</a>
        </div>
    </header>
</div>

<div class="row jiecao-value text-center">
    <div class="clearfix"><span class="pull-right glyphicon glyphicon-question-sign" style="color: gray;"></span></div>
    <h1 style="margin-top: 0;margin-bottom: 20px;"><?=$userData['jiecao_coin']?></h1>
    <h5 style="color: gray;font-size: 20px;"><img style="width: 40px;" src="<?=Yii::getAlias("@web")?>/images/member/jiecao_coin.png">&nbsp;节操余额</h5>
    <?php if($userData['frozen_jiecao_coin']>0):?>
        <a href="frozen-coin">
            <h5 style="border:1px solid #ececec;padding:10px;color:#bebebe;"><span>冻结节操币：<?=$userData['frozen_jiecao_coin']?></span><span class="glyphicon glyphicon-menu-right pull-right"></span></h5>
        </a>
    <?php endif;?>
</div>

<div class="row jiecao-recharge"></div>
<?php foreach($predefined as $key=>$item):?>
    <div class="row directer" data-id="<?=$item['id']?>" style="background-color: #fff;padding:10px;border-bottom: 1px solid #e8e8e8;line-height: 30px;">
        <div class="col-xs-2" style="padding-right: 0;padding-left:0;"><img class="center-block" style="width: 30px;" src="<?=Yii::getAlias("@web")?>/images/member/jiecao_coin.png"></div>
        <div class="col-xs-2" style="padding:0;"><?=$item['money']?></div>
        <div class="col-xs-4">
            <?php if($item['giveaway']==0):?>
                <span class="text-danger" style="font-size: 12px;"></span>
            <?php else:?>
                <span class="text-danger" style="font-size: 12px;">送<?=$item['giveaway']?>节操币</span>
            <?php endif;?>
        </div>
        <div class="col-xs-4" style="padding:0"><span class="btn btn-default pull-right" style="padding:4px 15px;">去充值</span></div>
    </div>
<?php endforeach;?>


<?php

$this->registerJs("
 $('.directer',this).on('click',function(){

        window.location.href = 'pay-type?id='+$(this).attr('data-id');

    });
");


?>

<!--<div class="row member-jiecao hidden">

    <div class="col-xs-4" style="background-color: #698dff;padding:10px;">
        <a href="/member-ship/jiecao-recharge">
            <div class="jiecao-icon">
                <span class="glyphicon glyphicon-glass" style="font-size: 20px;"></span>
            </div>
            <h4>充值</h4>
            <h5>支付宝</h5>
        </a>
    </div>
    <div class="col-xs-4" style="background-color: #ff8051;padding:10px;">
        <div class="jiecao-icon">
            <span class=" glyphicon glyphicon-credit-card" style="font-size: 20px;"></span>
        </div>
        <h4>节操币</h4>
        <h5><?/*=$userData['jiecao_coin']*/?></h5>
    </div>
    <div class="col-xs-4" style="background-color: #c56aff;padding:10px;">
        <a href="/member-ship/recharge-record">
            <div class="jiecao-icon">
                <span class="glyphicon glyphicon-time" style="font-size: 20px;"></span>
            </div>
            <h4>充值记录</h4>
            <h5>支付宝</h5>
        </a>
    </div>
</div>
<div class="row jiecao-service-title hidden">
    <h5>十三服务</h5>
</div>
<div class="row jiecao-service-content text-center hidden">
    <div class="col-xs-4">
        <a href="/date-today">
            <div class="service-icon"><span class="glyphicon glyphicon-asterisk"></span></div>
            <h5>今日密约</h5>
        </a>
    </div>
    <div class="col-xs-4" style="border-left:none;border-right:none;">
        <a href="http://13loveme.com:8888/red">
            <div class="service-icon"><span class="glyphicon glyphicon-time"></span></div>
            <h5>往日密约</h5>
        </a>

    </div>
    <div class="col-xs-4"></div>

</div>-->