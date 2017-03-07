<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/6
 * Time: 9:08
 */
$this->title = "会员设置";
$this->registerCss("

    .member-setting{padding:20px 10px;background-color:#fff;border-bottom:1px solid #ddd;}

");
?>

<div class="row member-setting">
    <a href="/user/setting">
        <div class="col-xs-10"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;个人档</div>
        <div class="col-xs-2"> <span class="glyphicon glyphicon-share-alt"></span></div>
    </a>
</div>

<div class="row member-setting">
    <a href="/setting/account">
        <div class="col-xs-10"><span class="glyphicon glyphicon-wrench"></span>&nbsp;&nbsp;&nbsp;账户设置</div>
        <div class="col-xs-2"> <span class="glyphicon glyphicon-share-alt"></span></div>
    </a>
</div>

<div class="row member-setting">
    <a href="/setting/security">
        <div class="col-xs-10"><span class="glyphicon glyphicon-lock"></span>&nbsp;&nbsp;&nbsp;密码修改</div>
        <div class="col-xs-2"> <span class="glyphicon glyphicon-share-alt"></span></div>
    </a>
</div>

<div class="row member-setting">
    <a href="/user/setting/avatar-update">
        <div class="col-xs-10"><span class="glyphicon glyphicon-picture"></span>&nbsp;&nbsp;&nbsp;用户头像</div>
        <div class="col-xs-2"> <span class="glyphicon glyphicon-share-alt"></span></div>
    </a>
</div>