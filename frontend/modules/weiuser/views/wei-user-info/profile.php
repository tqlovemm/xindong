<?php
$this->title = "档案";
?>
<div class="profile"><div class="weui-cells">
        <div class="weui-cell" id="avatarCell">
            <div class="weui-cell__bd">
                <p>头像</p>
            </div>
            <div class="weui-cell__ft">
                <img src="<?=$model->headimgurl?>" class="profile__avatar___2MB0k" alt="">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>名字</p>
            </div>
            <div class="weui-cell__ft">
                <?=$model->nickname?>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>十三编号</p>
            </div>
            <div class="weui-cell__ft">
                 <?=$model->thirteen_platform_number?>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>我的二维码</p>
            </div>
            <div class="weui-cell__ft">
                <i class="profile__icon-qrcode___2uQl2 profile__icon___2eco1"></i>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>我的地址</p>
            </div>
            <div class="weui-cell__ft">

            </div>
        </div>
    </div>

    <div class="weui-cells">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>性别</p>
            </div>
            <div class="weui-cell__ft">
                男
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>地区</p>
            </div>
            <div class="weui-cell__ft">
                奥地利 维也纳
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>个性签名</p>
            </div>
            <div class="weui-cell__ft">
                未填写
            </div>
        </div>
    </div>

    <div class="weui-cells">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>LinkedIn帐号</p>
            </div>
            <div class="weui-cell__ft">
                未设置
            </div>
        </div>
    </div>

</div>
