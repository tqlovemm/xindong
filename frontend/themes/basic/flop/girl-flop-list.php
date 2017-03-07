<?php
use yii\helpers\Url;
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

    #narrow{width:100%;height:100%;right:0;background-image:url(../images/flop/sharebb-shisan.png);background-size:300px 200px;background-repeat:no-repeat;background-color:rgba(72, 72, 72, 0.7);;background-position:70% 0;position: absolute;z-index:11;display:none;}

');



$this->registerJsFile('@web/js/flop/masonry-docs.min.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);

?>
<div id="narrow"></div>
<header>
    <div class="header">
        <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
        <h2><?=$this->title?></h2>
        <a href="<?=Url::to(['/flop/teach','sex'=>1])?>" style="right:3%;top:0;font-size:18px;line-height: 44px;">教程</a>
    </div>
</header>
<!--<div class="notice" style="text-align: center;padding:10px 5px;" >
    <div class="share-flop text-left" style="border-radius: 5px;box-shadow: 0 0 4px #B5B3B3;">
        <div style="width: 70%;padding:5px;" class="flop-introduction pull-left">
            <h4 style="color:#F14251;margin:0 0 5px 0;font-weight: bold;">翻牌三部曲（操作步骤）</h4>

            <div class="" style="font-size: 13px;line-height: 22px;">
                <div>① 单击选中或取消你想要翻牌的汉子图片</div>
                <div>② 将此页面通过浏览器或微信分享功能分享给十三客服</div>
                <div>③ 稍后汉子们会主动加你微信各种玩耍</div>
            </div>
        </div>
        <div style="width: 30%;" class="flop-weixin pull-right"><img class="img-responsive" src="<?/*=Yii::getAlias('@web')*/?>/images/weixin/1.jpg"></div>
    </div>
</div>-->
<div id="masonry" class="container-fluid" style="padding: 10px;">

        <?php foreach($model as $item):?>
            <div data-title="<?=$item['id']?>" class="box priority-img"  style="position: relative;">
                <img style="box-shadow: 3px 3px 5px #adadad;border-radius: 3px;" src="<?=$item['path']?>">

                <a class="delete-list" data-confirm="确认删除吗" href="<?=Url::toRoute(['/flop/delete','id'=>$item['id'],'flag'=>$flag])?>" style="position: absolute;right: 0;top:0; font-size: 18px;color:rgba(255, 255, 255, 0.56);">
                    <span class="glyphicon glyphicon-remove" style="background-color: rgba(239, 67, 79, 0.54);border-radius: 50%;border:1px solid rgba(239, 67, 79, 0.53);padding:2px;">

                    </span>
                </a>

                <span class="priority" style="width: 60px;height:60px;position: absolute;top:30%;left:50%;margin-left:-30px;
                background-color: rgba(239, 67, 79, 0.7);font-size: 18px;border-radius: 50%;line-height: 60px;text-align: center;;
                color:white;font-weight: bold;  <?php if(in_array($item['id'],$prioritys)){echo "display:block;";}?>">翻牌</span>
            </div>

        <?php endforeach;?>

</div>


<div class="text-center">
    <span id="share-flop" class="btn btn-self" style="width: 320px;">
        <a class="glyphicon glyphicon-share" style="background-color: white;color:#39C26A;padding:8px;border-radius:50%;"></a>
        分享给微信客服十三
    </span>
</div>

<div class="text-center" style="margin-top: 20px;margin-bottom: 20px;"><a class="btn btn-danger"  style="color:white;padding:4px 80px;width: 320px;height: 40px;line-height: 30px;" href="<?=Url::to(['/flop/clear-flop','sex'=>1])?>" data-confirm="确认清空吗">清空返回重选</a></div>

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

            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function stateChanged()
            {
                if (xhr.readyState==4 || xhr.readyState=="complete")
                {

                }
            };

            xhr.open('get','/index.php/flop/priority?id='+$(this).attr('data-title'));

            xhr.send(null);

        });



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