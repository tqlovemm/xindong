<?php
$session = Yii::$app->session;
if(!$session->isActive){
    $session->open();
}
$dinyue_userinfo = new \frontend\models\DinyueWeichatUserinfo();
$this->title = "详情";
$this->registerCss("
.weicaht-note-share,.weicaht-notes{width: 20%;padding: 6px 10px;border-radius: 4px;font-size: 14px;z-index: 100;border: none;color: #fff;box-shadow: 0 0 7px #d7d7d7;}
.weicaht-note-share{background-color: #22222E;}.weicaht-notes {background-color: rgb(231,0,108);}
.nav-tabs-top{width:100%;z-index:9;}
.contact{display:none;}
.adv_1,.adv_2{display:none;}
");

$this->registerJs("

    var obj = '.nav-tabs-top';
    var initPos = $(obj).offset().top;
    var distance = 0;
    
  	$(window).scroll(function(event) {		
        var objTop = $(obj).offset().top - $(window).scrollTop();
        if(objTop<=distance){
            $(obj).css('position','fixed');
            $(obj).css('top',distance+'px');
            $(obj).addClass('nav-tabs-shadow');
            $('.contact').css({'display':'block','margin-left':'-10px','margin-right':'-10px'});
            $(obj).css('margin-top','0');
        }
        if($(obj).offset().top<=initPos){
            $(obj).css('position','static');
            $(obj).removeClass('nav-tabs-shadow');
            $('.contact').css('display','none');
            $(obj).css('margin-top','10px');
        }
    });
");
?>
<script src="http://13loveme.com/js/jweixin-1.0.0.js"></script>
<div class="nav-tabs-top" style="padding:0 10px;background-color: #fff;margin-top: 10px;">
    <a class="contact" href="/contact">
        <img class="img-responsive" src="<?=Yii::getAlias('@web')?>/images/vote/669179008377191553.png">
    </a>

</div>
<div class="row" style="background-color: #fff;padding:10px;margin: 0;color:gray;">
    <div class="col-xs-6" style="margin: 0;padding:0;">当前排名：<?=$rank?></div>
    <div class="col-xs-6" style="margin: 0;padding:0;text-align: right;">距前一名还差：<?=$to?>票</div>
</div>
<div class="row" style="background-color: #fff;padding:10px;margin: 0;border-top: 1px solid #eee;border-bottom: 1px solid #eee;">
    <div class="col-xs-4 note-count" style="font-size: 15px;line-height: 27px;padding: 0;text-align: left;"> <?=$model['vote_count']?></div>
    <?php if(empty($dinyue_userinfo::findOne(['unionid'=>$session->get('vote_01_openid')]))):?>
        <a class="col-xs-4" style="padding:0;text-align: right;line-height: 27px;" data-lightbox="d" data-title="请关注微信订阅号进行投票" href="/images/weixin/149129585220305657.jpg">
            <span class="weicaht-notes">给TA投票</span>
        </a>
    <?php else:?>
        <div class="col-xs-4" style="padding:0;text-align: right;line-height: 27px;" data-sex="<?=$model['sex']?>" onclick="vote_notes(<?=$model['id']?>,this)">
            <span class="weicaht-notes">给TA投票</span>
        </div>
    <?php endif;?>
    <div class="col-xs-4" style="padding:0;text-align: right;line-height: 27px;">
        <span class="weicaht-note-share">为TA拉票</span>
    </div>
</div>
<div class="row" style="margin:10px 0 10px 0;background-color: #fff;padding:0 10px;font-size: 16px;">
    <div style="padding:10px 0 0;"><span style="color:#000;">参赛编号：</span><?=$model['id']?></div>
    <div style="padding:10px 0 0;"><span style="color:#000;">平台编号或微博号：</span><?=$model['number']?></div>
    <p style="padding:10px 0;margin: 0;"><span style="color:#000;">交友宣言：</span><?=$model['declaration']?></p>
</div>
<div class="row" style="padding:10px 10px;margin: 0 0 60px 0;background-color: #fff;">
    <?php foreach ($model->voteSignImgs as $item):?>
        <img style="margin-bottom: 10px;" class="img-responsive" src="<?=$item['img']?>">
    <?php endforeach;?>
</div>

<?php if(!empty($show['show'])):?>
    <div class="share-background" style="display: block;z-index: 9;width: 100%;height: 100%;position: absolute;top:0;left: 0;background-color: rgba(0, 0, 0, 0.7);">
        <img class="img-responsive" src="/images/vote/507617746878371284.png">
    </div>
<?php else:?>
    <div class="share-background" style="display:none;z-index: 9;width: 100%;height: 100%;position: absolute;top:0;left: 0;background-color: rgba(0, 0, 0, 0.7);">
        <img class="img-responsive" src="/images/vote/507617746878371284.png">
    </div>
<?php endif;?>
<?php
$this->registerJs("

    $('.weicaht-note-share').click(function(){
    
        $('body,html').animate({ scrollTop: 0 }, 300);
        $('.share-background').fadeIn();
        
    });
    $('.share-background').click(function(){
        $(this).fadeOut();
    });
    
    $('.share-background').on('touchmove',function(e){
        e.preventDefault();
    },false);

");
?>

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
        appId: '<?= $signPackage["appId"];?>',
        timestamp: '<?= $signPackage["timestamp"];?>',
        nonceStr: '<?= $signPackage["nonceStr"];?>',
        signature: '<?= $signPackage["signature"];?>',
        jsApiList: ['onMenuShareAppMessage','onMenuShareTimeline'
            // 所有要调用的 API 都要加到这个列表中
        ]
    });
    wx.ready(function () {
        // 在这里调用 API
        wx.onMenuShareAppMessage({
            title: '<?=$session->get('vote_01_nickname')?>邀您来投票', // 分享标题
            desc: '投票参与‘男神女神’评选，交友更有现金大奖拿。', // 分享描述
            link: 'http://13loveme.com/weixin/weichat-vote/sign-detail?id=<?=$model['id']?>&before=2', // 分享链接
            imgUrl: 'http://13loveme.com/<?=$item['img']?>', // 分享图标
            type: 'link', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
                alert('分享成功');

            },
            cancel: function () {
                // 用户取消分享后执行的回调函数条

                alert('取消分享');

            }
        });

        wx.onMenuShareTimeline({
            title: '投票参与‘男神女神’评选，交友更有现金大奖拿。', // 分享标题
            link: 'http://13loveme.com/weixin/weichat-vote/sign-detail?id=<?=$model['id']?>&before=2', // 分享链接
            imgUrl: 'http://13loveme.com/<?=$item['img']?>', // 分享图标
            success: function () {
                // 用户确认分享后执行的回调函数
                alert('分享成功');
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
                alert('取消分享');
            }
        });
    });
</script>