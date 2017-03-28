<?php
use yii\helpers\Url;
if(empty($openid)){
    $openid = Yii::$app->request->get('openid');
}
$this->title = "后宫档案";
$this->registerCss('

    .navbar,footer,.weibo-share{display:none;}
    header{width:100%;height:44px;background: #EF434F;position: relative;z-index: 10;}
    header a{color:white;position: absolute;}
    header h2{color: #fff;font-size: 16px;font-weight: normal;height:44px;text-align: center;line-height:44px;font-weight: bold;margin-top: 0;}
    header span{display: block;height: 35px;text-indent: 17px;width: 50px;color: #FFF;font-size: 14px;padding-top: 8px;margin-left: -10px;}
    header span img{width: 25px;}
    .container-fluid {padding: 20px;}
    .box {margin-bottom: 20px;float: left;width: 43%;}
    .box img {max-width: 100%;}
    .priority{display:none;}
     .btn-self{color:white;background-color:#39C26A;border-color:#39C26A;padding:4px 80px;}
    .share-flop{background-color:#eee;padding: 2px;color:gray;}
    .share-flop:after{content:".";height:0;clear:both;display:block;visibility: hidden;}
    a:hover {
        color:white;
        text-decoration: none;
    }

    #narrow{width:100%;height:100%;right:0;background-image:url(../images/flop/narrow2.png);background-size:100%;background-repeat:no-repeat;background-color:rgba(72, 72, 72, 0.7);;background-position:70% 0;position: absolute;z-index:11;display:none;}
    
    .list{background-color: #fff;padding:10px;box-shadow: 0 0 5px #dedede;margin: 0;}
    .list .list-box{color:#000;}
    .list-box{font-size: 22px;}
    .list-box.list-box-border{border-left: 1px solid #ddd;border-right:1px solid #ddd;}
    .list-box h5{font-weight: bold;margin: 0;}

');
$pre_url = Yii::$app->params['imagetqlmm'];
$this->registerJsFile('@web/js/flop/masonry-docs.min.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);
?>
<script src="http://13loveme.com/js/jweixin-1.0.0.js"></script>
<div id="narrow" style="color:#fff;font-size: 26px;line-height: 50px;padding-top: 40%;text-align: center;">
    <h1>分享给微信客服:</h1>
</div>

<div class="row list">
    <a href="http://13loveme.com/w-flop/comments?openid=<?=$openid?>" class="col-xs-4 text-center list-box" style="position: relative;">
        <div class="list-icon">
            <span class="glyphicon glyphicon-pencil"></span>
        </div>
        <h5>待评价</h5>
        <?php if($count!=0):?>
        <span class="badge" style="position: absolute;right:10px;top:0;background-color: red;"><?=$count?></span>
        <?php endif;?>
    </a>
    <a href="<?=$web_url?>teach?openid=<?=$openid?>" class="col-xs-4 text-center list-box list-box-border">
        <div class="list-icon">
            <span class="glyphicon glyphicon-question-sign"></span>
        </div>
        <h5>教程</h5>
    </a>
    <a href="<?=$web_url?>history?openid=<?=$openid?>" class="col-xs-4 text-center list-box">
        <div class="list-icon">
            <span class="glyphicon glyphicon-list-alt"></span>
        </div>
        <h5>历史记录</h5>
    </a>
</div>

<div id="masonry" class="container-fluid" style="padding: 10px 10px 50px;">
    <?php foreach($model as $item):
        $img = (new \yii\db\Query())->select('number,content,area')->from('pre_flop_content')->where(['id'=>$item['priority']])->one();
        ?>
        <div data-title="<?=$item['priority']?>" class="box priority-img"  style="position: relative;background-color: #fff;padding:10px;">
            <img style="box-shadow: 3px 3px 5px #adadad;border-radius: 3px;" src="<?=$pre_url.$img['content']?>">
            <h5 style="margin-bottom: 0;">编号：<?=$img['number']?></h5>
            <h5 style="margin-bottom: 0;">地区：<?=$img['area']?></h5>

            <a class="delete-list" data-confirm="确认删除吗" href="<?=Url::toRoute(['delete','id'=>$item['id'],'flag'=>$flag,'openid'=>$openid])?>" style="position: absolute;right: 0;top:0; font-size: 18px;color:rgba(255, 255, 255, 0.56);">
                <span class="glyphicon glyphicon-remove" style="background-color: rgba(239, 67, 79, 0.54);border-radius: 50%;border:1px solid rgba(239, 67, 79, 0.53);padding:2px;"></span>
            </a>
            <span class="priority" style="width: 60px;height:60px;position: absolute;top:30%;left:50%;margin-left:-30px;
            background-color: rgba(239, 67, 79, 0.7);font-size: 18px;border-radius: 50%;line-height: 60px;text-align: center;
            color:white;font-weight: bold;<?php if($item['status']==1){echo "display:block;";}?>">翻牌</span>
        </div>
    <?php endforeach;?>
</div>

<div class="text-center navbar-fixed-bottom" style="bottom:10px;">
    <span id="share-flop" class="btn btn-self" style="width: 320px;">
        <a class="glyphicon glyphicon-share" style="background-color: white;color:#39C26A;padding:8px;border-radius:50%;"></a>
        分享给微信客服
    </span>
</div>
<script>

    $(function() {

        $("html,body").animate({scrollTop:document.body.scrollHeight}, 500);

        $('#share-flop').on('click',function(){
            $("html,body").animate({scrollTop:0}, 500);

            $('#narrow').fadeIn(function(){

                $("body").on("touchmove",function(e){
                    e.preventDefault();
                },false);
            });
        });

        $('#narrow').on('click',function(){

            $('#narrow').hide(function(){

                $("body").off('touchmove');
            });

        });

        var height1 = $('.flop-introduction').outerHeight();
        var height2 = $('.flop-weixin').outerHeight();
        var height = (height1-height2)>=0?(height1-height2):0;

        $('.flop-weixin').css('margin-top',height/2);

        $('.delete-list').click(function(e){
            e.stopPropagation();
        });

        $('.priority-img').on('click',function(){

            $(this).children('.priority').fadeToggle();

            $.get('priority?openid=<?=$openid?>&id='+$(this).attr('data-title'),function () {

            });
        });

        //瀑布流显示图片
        var $container = $('#masonry');
        $container.imagesLoaded(function() {
            $container.masonry({
                itemSelector: '.box',
                gutter: 20,
                isAnimated: true,
            });
        });
    });
</script>
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
            title: '后宫翻牌分享', // 分享标题
            desc: '后宫翻牌内容，请分享给十三平台客服', // 分享描述
            link: '', // 分享链接
            imgUrl: '', // 分享图标
            type: 'link', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
                window.location.href='clear-flop?openid=<?=$openid?>';

            },
            cancel: function () {
                // 用户取消分享后执行的回调函数条

                alert('取消分享客服将不知道您翻牌的内容哦');

            }
        });
    });
</script>
