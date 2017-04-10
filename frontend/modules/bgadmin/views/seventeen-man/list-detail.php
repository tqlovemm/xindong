<?php
$this->title = "选中的女生";
$this->registerCssFile("@web/css/note/base.css");
$this->registerCssFile("@web/css/note/style.css");
$this->registerCss("
    .navbar,footer,.weibo-share{display:none;}
    .article{margin-bottom:10px;}
    .list-header{position: relative;margin: 0;}
    .list-header a{position: absolute;top:0;color:#EFB810;font-size: 16px;padding:10px 10px 0;}
    .list-header h4{background-color: #1C1B21;padding:10px 0;margin-top: 0;color: #EFB810;font-weight: bold;}
    #share_arrow{position: absolute;right: 0;top:0;z-index: 9;width: 100%;height: 100%;background-color: rgba(0, 0, 0, 0.63);padding:0 10px;display: none;}
    #share{width: 60%;padding:5px;border-radius: 50px;border: 2px solid #F3BA0A;color:#F3BA0A;font-size:20px;background-color: transparent;margin-bottom: 10px;}
");
$qiniu = Yii::$app->params['qiniushiqi'];
?>
<script src="http://13loveme.com/js/jweixin-1.0.0.js"></script>
<div id="share_arrow">
    <img class="img-responsive" src="/images/weixin/2000.png">
</div>
<div class="row list-header">
    <h4 class="text-center"><?=$this->title?></h4>
    <a href="seventeen-code" style="left:15px;"><span class="glyphicon glyphicon-home"></span></a>
   <!-- <a href="history" style="right:15px;"><span>历史</span></a>-->
</div>
<div class="row" style="padding-bottom: 60px;margin: 0;">
    <ul class="wall">
        <?php foreach ($query as $item):?>
            <li class="article">
                <a style="background-color: #fff;display: block;position: relative;" href="seventeen-single?id=<?=$item['id']?>">
                    <?php foreach ($item['imgs'] as $img):
                        $extend = explode('.',$img['img']); ?>
                        <h5 style="margin-top: 0;">编号：<?=$item['id']?></h5>
                        <img class="img-responsive" src="<?=$qiniu.$img['img']?>"/>
                        <?php if(in_array($extend[count($extend)-1],['jpg','png','jpeg','bmp','JPG','PNG','JPEG','BMP'])){break;}
                    endforeach; ?>
                    <h5>区域：<?=$item['address_city']?></h5>
                    <h5><?=$item['age']?> 岁 &nbsp;<?=$item['height']?>cm &nbsp;<?=$item['weight']?>kg</h5>
                    <div style="position: absolute;width: 100%;height: 100%;top:0;"></div>
                </a>
            </li>
        <?php endforeach;?>
    </ul>
</div>

<div class="text-center row" style="background-color: rgba(0, 0, 0, 0.6);position: fixed;bottom:0;width: 100%;padding-top: 10px;margin: 0;">
    <button id="share">分享给客服 <span class="glyphicon glyphicon-share-alt"></span></button>
</div>

<?php
$img = isset($img['img'])?$img['img']:'';
$this->registerJs("
/*瀑布流*/
$('.wall').jaliswall({ item: '.article' });
");
?>
<script>
    $(function () {
        $('#share').click(function(){
            $('#share_arrow').show();
        });
        $('#share_arrow').bind('touchmove',function(e){
            e.preventDefault();
        });
        $('#share_arrow').on('click',function(){
            $(this).fadeOut();
        });
    });
</script>
<script>
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
            desc: '请及时分享给客服，客服会帮你联系她，记住一定要分享给客服哦，过期无效。', // 分享描述
            link: 'http://13loveme.com/bgadmin/seventeen-man/share-list?flag=<?=$flag?>', // 分享链接
            imgUrl: '<?=$qiniu.$img?>', // 分享图标
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
