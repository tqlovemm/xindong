<?php

use yii\helpers\HtmlPurifier;
$this->title = '会员中心';
$this->registerCss("

    .member-avatar,.member-nickname{padding:10px 20px;overflow: hidden;background-color:white;border-bottom:1px solid #ddd;}
    .member-avatar{height:90px;}
    .member-nickname{height:50px;}
    .col-xs-5,col-xs-7{height:100%;}
    .col-xs-5{padding-left:0;font-weight: bold;}
    .col-xs-7{padding-right: 0;line-height: 30px;text-align: right;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;}
    .member-avatar .col-xs-7 img{height:70px;width:70px;}
    .member-nickname .col-xs-5{line-height: 30px;}
    .member-avatar .col-xs-5{line-height: 70px;}




    ");
?>
<div class="row member-avatar">
    <div class="col-xs-5">头像</div>
    <div class="col-xs-7"><img src="<?=$model['avatar']?>"></div>
</div>
<div class="row member-nickname">
    <div class="col-xs-5">昵称</div>
    <div class="col-xs-7"><?=HtmlPurifier::process($model['nickname'])?></div>
</div>
<div class="row member-nickname">
    <div class="col-xs-5">会员名</div>
    <div class="col-xs-7"><?=HtmlPurifier::process($model['username'])?></div>
</div>
<div class="row member-nickname">
    <div class="col-xs-5">十三服务号</div>
    <div class="col-xs-7"><?=$profile['number']?></div>
</div>
<div class="row member-nickname" style="margin-bottom: 20px;">
    <div class="col-xs-5">微信号</div>
    <div class="col-xs-7"><?=$profile['weichat']?></div>
</div>


<div class="row member-nickname">
    <div class="col-xs-5">生日</div>
    <div class="col-xs-7"><?=$profile['birthdate']?></div>
</div>
<div class="row member-nickname">
    <div class="col-xs-5">性别</div>
    <div class="col-xs-7"><?=$model['sex']?></div>
</div>
<div class="row member-nickname">
    <div class="col-xs-5">身高</div>
    <div class="col-xs-7"><?=$profile['height']?>cm</div>
</div>
<div class="row member-nickname">
    <div class="col-xs-5">体重</div>
    <div class="col-xs-7"><?=$profile['weight']?>kg</div>
</div>
<div class="row member-nickname">
    <div class="col-xs-5">地区</div>
    <div class="col-xs-7"><?=$profile['address']?></div>
</div>
<div class="row member-nickname">
    <div class="col-xs-5">个人签名</div>
    <div class="col-xs-7"><?=HtmlPurifier::process($profile['signature'])?></div>
</div>

