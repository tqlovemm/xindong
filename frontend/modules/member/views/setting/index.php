<?php

use yii\helpers\Html;
$this->title = "设置";
$this->registerCss("

    .member-setting{background-color: #fff;padding:10px;margin-top: 10px;}

");
?>

<div class="row member-center">
    <header>
        <div class="header">
            <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
            <h2 style="margin:0;"><?=$this->title?></h2>
        </div>
    </header>
</div>
<div class="row member-setting">
    <a href="setting/profile">
        <div class="col-sm-2 col-xs-2"><span class="glyphicon glyphicon-list-alt" style="color: #6aa7ff;"></span></div>
        <div class="col-sm-10 col-xs-10" style="padding: 0;">个人资料</div>
    </a>
</div>
<!--<div class="row member-setting">
    <a href="setting/mark">
        <div class="col-sm-2 col-xs-2"><span class="glyphicon glyphicon-tags" style="color: #ff6a1b;"></span></div>
        <div class="col-sm-10 col-xs-10" style="padding: 0;">我的标签</div>
    </a>
</div>-->
<div class="row member-setting">
    <a href="setting/account">
        <div class="col-sm-2 col-xs-2"><span class="glyphicon glyphicon-wrench" style="color: #ff0fce;"></span></div>
        <div class="col-sm-10 col-xs-10" style="padding: 0;">账户资料</div>
    </a>
</div>
<!--<div class="row member-setting">
    <a href="setting/avatar-update">
        <div class="col-sm-2 col-xs-2"><span class="glyphicon glyphicon-picture" style="color: #e38aff;"></span></div>
        <div class="col-sm-10 col-xs-10" style="padding: 0;">档案照片</div>
    </a>
</div>-->
<div class="row member-setting">
    <a href="setting/security">
        <div class="col-sm-2 col-xs-2"><span class="glyphicon glyphicon-lock" style="color: orange;"></span></div>
        <div class="col-sm-10 col-xs-10" style="padding: 0;">密码修改</div>
    </a>
</div>

<div class="row">
    <?= Html::a('退出登录', ['/logout'], [
        'class' => 'btn btn-success center-block',
        'style'=>'margin-top: 100px;width: 95%;border-radius: 0;font-size: 16px;',
        'data-confirm'=>'确认退出吗'
    ]) ?>
</div>