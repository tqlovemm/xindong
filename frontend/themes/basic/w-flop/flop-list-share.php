<?php
$this->title = "后宫档案分享页面";
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

    #narrow{width:100%;height:100%;right:0;background-image:url(../images/flop/narrow.png);background-size:300px 200px;background-repeat:no-repeat;background-color:rgba(72, 72, 72, 0.7);;background-position:70% 0;position: absolute;z-index:11;display:none;}
    
    .list{background-color: #fff;padding:10px;box-shadow: 0 0 5px #dedede;margin: 0;}
    .list .list-box{color:#000;}
    .list-box{font-size: 22px;}
    .list-box.list-box-border{border-left: 1px solid #ddd;border-right:1px solid #ddd;}
    .list-box h5{font-weight: bold;margin: 0;}

');
$pre_url = Yii::$app->params['imagetqlmm'];
$this->registerJsFile('@web/js/flop/masonry-docs.min.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);
?>
<div style="padding:10px;background-color: #fff;text-align: center;margin-bottom: 10px;">此页面为会员分享页面，不可操作！图片点击可放大</div>
<div id="masonry" class="container-fluid" style="padding: 10px;">
    <?php foreach($model as $item):
        $img = (new \yii\db\Query())->select('content,number,area')->from('pre_flop_content')->where(['id'=>$item['priority']])->one();
        ?>
        <a href="<?=$pre_url.$img['content']?>" data-lightbox="0" data-title="翻牌后宫" class="box priority-img"  style="position: relative;background-color: #fff;padding:10px;">
            <img style="box-shadow: 3px 3px 5px #adadad;border-radius: 3px;" src="<?=$pre_url.$img['content']?>">
            <h5 style="margin-bottom: 0;">编号：<?=$img['number']?></h5>
            <h5 style="margin-bottom: 0;">地区：<?=$img['area']?></h5>
            <span class="priority" style="width: 60px;height:60px;position: absolute;top:30%;left:50%;margin-left:-30px;
            background-color: rgba(239, 67, 79, 0.7);font-size: 18px;border-radius: 50%;line-height: 60px;text-align: center;
            color:white;font-weight: bold;<?php if($item['status']==1){echo "display:block;";}?>">翻牌</span>
        </a>
    <?php endforeach;?>
</div>
<script>

    $(function() {

        $("html,body").animate({scrollTop:document.body.scrollHeight}, 500);

        var height1 = $('.flop-introduction').outerHeight();
        var height2 = $('.flop-weixin').outerHeight();
        var height = (height1-height2)>=0?(height1-height2):0;

        $('.flop-weixin').css('margin-top',height/2);

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

