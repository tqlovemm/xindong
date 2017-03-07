<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\myhelper\Helper;
use backend\modules\weekly\models\Weekly;
/*
 *               <div class="col-xs-4 col-sm-2 col-sm-offset-2 col-md-1 col-md-offset-4" style="padding-left: 10px;padding-right: 10px;">
                    <img class="img-responsive" style="width: 100%;" src="<?=$model['avatar']?>">
                </div>
                <div class="col-xs-8 col-md-3 col-sm-7" style="padding-left: 0;">
                    <h4 class="title1"><?=Helper::truncate_utf8_string($model['title'],10);?></h4>
                    <div class="content1">
                        <span><?=Helper::truncate_utf8_string($model['content'],20);?></span>
                    </div>
                </div>
 * */
/* @var $this yii\web\View */
/* @var $searchModel app\modules\show\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '心动周刊';
$this->params['breadcrumbs'][] = $this->title;
use yii\web\View;
 $this->registerJsFile("/js/TouchSlide.1.1.source.js",['position' => View::POS_HEAD]);

$this->registerCss('
    #weibo__guanzhu{display:none;}
    body{background-color:white;}
    body,html{height:auto !important;}
    .slideBox{ position:relative; width:100%;  height:auto;padding:0 1px; overflow:hidden; margin:10px auto; }
	.slideBox .hd{ position:absolute; height:28px; line-height:28px; bottom:0; right:0; z-index:1; }
	.slideBox .hd li{ display:inline-block; width:5px; height:5px; -webkit-border-radius:5px; -moz-border-radius:5px; border-radius:5px; background:#fff; text-indent:-9999px; overflow:hidden; margin:0 6px;   }
	.slideBox .hd li.on{ background:#f33;  }
	.slideBox .bd{ position:relative; z-index:0; }
	.slideBox .bd li{ position:relative;  }
	.slideBox .bd li img{ display:block;   }
	.slideBox .bd li a{ -webkit-tap-highlight-color:rgba(0, 0, 0, 0); /* 取消链接高亮 */ }
	.slideBox .bd li .tit{ display:block; width:100%; font-size: 16px; position:absolute; bottom:0; text-indent:10px; height:28px; line-height:28px;  color:black;   }
    .content1{font-size: 15px;color: gray;width: 100%;display: inline-block;}
    .title1{color: #000;margin-top:5px;margin-bottom:10px;}

    .heartweek-box:after{content:".";display:block;clear:both;height:0;visibility: hidden;}

    .heartweek-box img{max-width:100px;}
    .heartweek-left{width:25%;overflow:hidden;margin-right:15px;}
    .heartweek-right{width:70%;overflow:hidden;}

    .nav-tabs > li{margin-bottom:0;}
    .nav-tabs > li > a{border:none;}
   .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus
    {background-color: #CA5254;
     border: none;
     border-bottom-color: transparent; }
     #heart-week-list{background-color:#3D3D3D;margin-bottom:10px;}
     #heart-week-list li{width:33.3%;text-align:center;}
     #heart-week-list li a{border-radius:0;color:white;font-size:20px;}

     .jAudio--playlist-item,#show-news-top div,#show-news-top{ -webkit-transition: all 0.5s ease 0s;transition: all 0.5s ease 0s;}
     .jAudio--playlist-item *{-webkit-transition: all 0.3s ease 0s;transition: all 0.3s ease 0s;}
      .jAudio--playlist-item.active *{color:white;}
      .jAudio--playlist-thumb {float: left;margin-right: 0.66667rem;display: table;}
.jAudio--playlist-thumb img {
    height: 4rem;
    width: 4rem;
    border-radius: 50%;
    float: left;
    margin-right: 0.5rem;
}
.jAudio--playlist-item {
    display: block;
    width: 100%;
    padding: 1.33333rem 2rem;
    display: table;
    border-bottom: 1px solid #dadada;

}

#slideBox{postion:fixed;}
.jAudio--playlist-item.active {
    background: #f55c5c;
    border-bottom-color: #f55c5c;
}
    @media (min-width:768px){
     .heartweek-box{width:450px;margin:auto;}
    }
    @media (width: 414px) {



    }
    @media (max-width: 370px) {

        .title1{font-size:20px;}


    }

');
?>

<div class="show-news-index">

    <ul class="list-unstyled">

    </ul>
    <div id="show-news-top">
        <div id="slideBox" class="slideBox">

            <div class="bd">
                <ul>
                    <?php foreach($query as $val):?>

                        <?php $url = !empty($val['thumb'])?$val['thumb']:"heart-slide/$val[id]";?>
                    <li>
                        <a class="pic" href="<?=$url?>">
                            <img class="img-responsive center-block" src="<?=$val['path']?>" />
                        </a>
    <!--                    <a class="tit">--><?//=$val['name']?><!--</a>-->
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>

            <div class="hd">
                <ul></ul>
            </div>
        </div>
        <script type="text/javascript">
            TouchSlide({
                slideCell:"#slideBox",
                titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
                mainCell:".bd ul",
                autoPlay:true,
                effect:"leftLoop",
                autoPage:true //自动分页

            });
        </script>


        <ul id="heart-week-list" class="nav nav-tabs">
            <li class="">
                <a href="#home" data-toggle="tab">反馈</a>
            </li>
            <li class='active'><a href="#voice" data-toggle="tab">声色</a></li>
            <li>
                <a href="#active" data-toggle="tab">活动</a>
            </li>
        </ul>
    </div>
    <div id="heart-week-content" class="tab-content">
        <div class="tab-pane fade" id="home">
            <?php foreach($models as $model):?>
                <a href="<?php echo \yii\helpers\Url::to(['week-content','id'=>$model['id']])?>" style="display: block;">
                    <div class="row" style="margin: 0;border-bottom:1px solid #dadada;padding:0 10px;">
                        <div class="heartweek-box">
                            <div class="pull-left heartweek-left">
                                <img class="img-responsive center-block" style="width: 100%;border-radius: 10px; " src="<?php echo $model['avatar']?>">
                            </div>
                            <div class="pull-left heartweek-right">
                                <h3 class="title1"><?php echo Helper::truncate_utf8_string($model['title'],9);?></h3>
                                <div class="content1">
                                    <span><?php echo Helper::truncate_utf8_string($model['content'],25);?></span>

                                </div>
                                <h6> <span><?php echo $model['url']?></span>/<span><?php echo date('Y年m月d日',$model['created_at'])?></span></h6>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach;?>
        </div>
        <div class="tab-pane fade in active" id="voice">
            <audio id="audio" autoplay="autoplay"></audio>

            <?php foreach($voices as $item):?>
                <div class="row" style="margin: 0;">
                    <div class="jAudio--playlist-item" data-track="<?=$item['file']?>"><div class="jAudio--playlist-thumb"><img src="<?=$item['avatar']?>"></div><div class="jAudio--playlist-meta-text"><h4 style="font-size: 1.1em;margin-top: 5px;font-family:'Open Sans';"><?=Helper::truncate_utf8_string($item['title'],12)?></h4><p><?=date('Y/m/d',$item['created_at'])?></p></div></div>
                </div>
            <?php endforeach;?>


            <script>

                $(function(){

                $(window).on("click", function(){
                    $("#audio").trigger("load").trigger("play");
                    $(this).off("click");
                });
                    $('.jAudio--playlist-item').eq(0).addClass('active');

                    $('.jAudio--playlist-item',this).on('click',function(){

                        $('.jAudio--playlist-item').removeClass('active');
                        $(this).addClass('active');
                        $('#audio').attr('src', $(this).attr('data-track'));

                    });
                    audioEl.load();

                })

            </script>

        </div>
        <div class="tab-pane fade" id="active">
            <?php foreach($actives as $model):?>
                <a href="<?=\yii\helpers\Url::to(['week-content','id'=>$model['id']])?>" style="display: block;">
                    <div class="row" style="margin: 0;border-bottom:1px solid #dadada;padding:0 10px;">
                        <div class="heartweek-box">
                            <div class="pull-left heartweek-left">
                                <img class="img-responsive center-block" style="width: 100%;border-radius: 10px; " src="<?=$model['avatar']?>">
                            </div>
                            <div class="pull-left heartweek-right">
                                <h3 class="title1"><?=Helper::truncate_utf8_string($model['title'],9);?></h3>
                                <div class="content1">
                                    <span><?=Helper::truncate_utf8_string($model['content'],12);?></span>

                                </div>
                                <h6> <span><?=$model['url']?></span>/<span><?=date('Y年m月d日',$model['created_at'])?></span></h6>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach;?>
        </div>
    </div>

</div>

