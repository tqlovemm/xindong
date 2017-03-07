<?php
    $areas = array_filter(explode('，',$model['address']));
    $this->title = "可进入地区";
?>
<script src="http://13loveme.com/js/jweixin-1.0.0.js"></script>
<div class="container-fluid" style="padding: 0;">
    <div class="row">
        <p style="padding: 10px;background-color: #fff;font-size: 16px;">
            以下是您可进入的地区，想要更多地区您可以直接点击底部开通新地区也可以联系客服开通哦。
        </p>
    </div>
    <div class="row">
        <?php foreach ($areas as $list):?>
            <a style="display: block;background-color: #fff;padding:10px 5px;border-bottom: 1px solid #eee;" href="seventeen-list?area=<?=$list?>">
                <div class="col-xs-8">
                    <?=$list?>
                </div>
                <div class="col-xs-4 text-right"><span class="glyphicon glyphicon-menu-right"></span></div>
                <div class="clearfix"></div>
            </a>
        <?php endforeach;?>
        <a href="add-address" style="display: block;background-color: #fff;padding:10px 5px;font-size: 18px;">
            <div class="col-xs-12 text-center">
                <span class="glyphicon glyphicon-plus"></span>
                开通新地区
            </div>
            <div class="clearfix"></div>
        </a>
    </div>
</div>
<script>
    /*
     * 注意：
     * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
     * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
     * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
     *
     * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
     * 邮箱地址：weixin-open@qq.com
     * 邮件主题：【微信JS-SDK反馈】具体问题
     * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
     */

    wx.config({
        debug: false,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: '<?php echo $signPackage["timestamp"];?>',
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: ['onMenuShareAppMessage'
            // 所有要调用的 API 都要加到这个列表中
        ]
    });
    wx.ready(function () {
        // 在这里调用 API

        wx.onMenuShareAppMessage({
            title: '高端会员交友', // 分享标题
            desc: '请分享给客服，客服会帮你联系她的哦，记住一定要分享给客服哦', // 分享描述
            link: 'http://13loveme.com/wei-xin/share-list', // 分享链接
            imgUrl: 'http://13loveme.com', // 分享图标
            type: 'link', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
                window.location.href='remove-cookie';
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数条

                alert('取消分享,客服将不知道您想要谁哦');

            }
        });

    });
</script>