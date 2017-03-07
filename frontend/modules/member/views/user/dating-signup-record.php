<?php
use yii\helpers\HtmlPurifier;
$this->title = '约会记录';
$this->registerCss("
    .member-avatar,.member-nickname{padding:10px 15px;overflow: hidden;background-color:white;}
    .member-avatar{height:80px;}
    .member-avatar .col-xs-3{width:60px;}
    .col-xs-7,.col-xs-3,.col-xs-1,.col-xs-5{height:100%;}
    .col-xs-3{padding-left: 0;padding-right:0;line-height: 30px;text-align: left;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;}
    .member-avatar .col-xs-3 img{height:60px;width:100%;}
    .member-nickname{height:50px;margin-top:15px;}
    .member-nickname .col-xs-1{line-height: 30px;font-size: 16px;padding:0;}
    .member-nickname .col-xs-1 .glyphicon-credit-card{color:#40A1FB;}
    .member-nickname .col-xs-1 .glyphicon-picture{color:#FBBC40;}
    .member-nickname .col-xs-1 .glyphicon-tower{color:#D04D9A;}
    .member-nickname .col-xs-1 .glyphicon-cloud-upload{color:#FBBC40;}
    .member-nickname .col-xs-1 .glyphicon-phone{color:#E94A16;}
    .member-nickname .col-xs-5{line-height: 25px;font-size: 14px;}

            /*phone*/

    .avatar{padding:10px;background: #23212E;color:#fff;}
    .member-info{font-size:12px;background:#fff;}
    .member-info .info-box{padding: 15px 15px 10px ;}
    .member-info .info-box .icon-bar{text-align: center;font-size: 25px;margin-bottom: 10px;}
    .info-content {color:gray;}
    .box1{border-bottom: 1px #E6E6E6 solid;border-right: 1px #E6E6E6 solid;}
    .box1 .icon-bar{color: orange;}
    .box2 .icon-bar{color: #EB4F38;}
    .box3 .icon-bar{color: orange;}
    .box4 .icon-bar{color: #ED9233;}

    .box2{border-bottom: 1px #E6E6E6 solid;}
    .box3{border-right: 1px #E6E6E6 solid;}

    .member-list{font-size:14px;background:#fff;padding:10px 0 10px;border-bottom:1px solid #eee;}

    ");
?>
    <div class="row member-center">
        <header>
            <div class="header">
                <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
                <h2 style="margin:0;"><?=$this->title?></h2>
                <a id="list_01" href="/member/setting" class="glyphicon glyphicon-cog" style="right:3%;top:0;font-size:20px;line-height: 44px;position: absolute;"></a>
            </div>
        </header>
    </div>
<div class="row member-list">
    <a href="dating-record" style="color:#ff6e60;">
        <div class="col-sm-2 col-xs-2" style="font-size: 16px;">
            <span class="glyphicon glyphicon-heart"></span>
        </div>
        <div class="col-sm-10 col-xs-10">觅约记录<span class="badge pull-right" style="background-color: red;"><?php if($date_num!=0){echo $date_num;}?></span></div>
    </a>
</div>
<div class="row member-list">
    <a href="firefighter-record">
        <div class="col-sm-2 col-xs-2" style="font-size: 16px;">
            <span class="glyphicon glyphicon-flash"></span>
        </div>
        <div class="col-sm-10 col-xs-10">福利救火<span class="badge pull-right" style="background-color: red;"><?php if($fire_num!=0){echo $fire_num;}?></span></div>
    </a>
</div>

<?=$this->render('@app/themes/basic/layouts/bottom')?>