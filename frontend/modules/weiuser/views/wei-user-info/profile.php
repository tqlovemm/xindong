<?php
use common\components\Vip;
    $this->title = "档案";
    $this->registerCss("
        .weui-cells{font-size:14px;}
    ");
?>
<div class="profile">
    <div class="weui-cells">
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
        <a href="javascript:;" class="weui-cell" id="showIOSActionSheet">
            <div class="weui-cell__bd">
                <p>性别</p>
            </div>
            <div id="sex" class="weui-cell__ft">
                <?=Vip::sex($model->sex)?>
            </div>
        </a>
        <a class="weui-cell" id="cascadePickerBtn" href="country">
            <div class="weui-cell__bd">
                <p>地区</p>
            </div>
            <div class="weui-cell__ft">
                <?=Vip::cnArea($model->area->country,$model->area->province,$model->area->city)?>
            </div>
        </a>
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

<script>
    $('#showIOSActionSheet').on('click',function () {
        $('#iosMask').css({'opacity':1,'display':'block'});
        $('#iosActionsheet').show();
    });
    $(function () {
        $('#iosActionsheetCancel').on('click',function () {
             $('#iosMask').css({'opacity':0,'display':'none'});
             $('#iosActionsheet').hide();
        });
    });

    function saveSex(sex,con) {
        var c = $(con);
        $('#sex').html(c.html());
        $('#iosMask').css({'opacity':0,'display':'none'});
        $('#iosActionsheet').fadeOut(200,function () {
            $.get('save-sex?sex='+sex,function (data) {
                alert(data);
            })
        });


    }

</script>

<div>
    <div class="weui-mask" id="iosMask" style="opacity: 0; display: none;"></div>
    <div class="weui-actionsheet" id="iosActionsheet">
        <div class="weui-actionsheet__title">
            <p class="weui-actionsheet__title-text">性别</p>
        </div>
        <div class="weui-actionsheet__menu">
            <div class="weui-actionsheet__cell" onclick="saveSex(0,this)">男</div>
            <div class="weui-actionsheet__cell" onclick="saveSex(1,this)">女</div>
        </div>
        <div class="weui-actionsheet__action">
            <div class="weui-actionsheet__cell" id="iosActionsheetCancel">取消</div>
        </div>
    </div>
</div>