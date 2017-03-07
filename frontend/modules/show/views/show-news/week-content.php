<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
$this->title="心动周刊";

$title = empty($queries['name'])?$query['title']:$queries['name'];
$this->registerCss('

        body,html{height:auto !important;}
        body{background-color:white !important;}
        .comment{padding:10px;width:100%;margin-bottom:10px;border-bottom:1px solid #ddd;}
        .comment:after{content:".";display: block;height:0;visibility: hidden;clear:both;}
        .write-comment{margin: 0;padding:5px 15px;}
        .write-comment,
        .write-comment a{color:#ff1a10;}
        #weibo__guanzhu{display:none;}

');

if(isset($_GET['top'])&&$_GET['top']=='bottoms'){

    $this->registerCss('
        nav,footer,.active-comment{display:none;}
    ');
}

?>
<meta property="og:type" content="webpage" />
<meta property="og:url" content="http://13loveme.com/heart" />
<meta property="og:title" content="心动故事" />
<meta property="og:description" content="十三交友平台心动故事" />

<div class="container">
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-12">
            <h4 style="font-weight: bold;color:black;margin-bottom: 0;"><?=$title?></h4>
            <time style="font-size: 11px;"><?=date('Y-m-d',$query['created_at'])?></time>
        </div>

    </div>
    <div class="row" style="border-bottom: 1px solid #a4a4a4;">

        <?php foreach($model as $item):?>

        <div class="col-md-12">
            <img class="img-responsive center-block" src="<?=$item['path']?>">

            <?=$this->render('word_style',[
                'model'=>$item
            ])?>

        </div>

        <?php endforeach;?>
    </div>
    <div class="row" style="padding:10px;font-weight:500;font-size: 12px;">
        <div class="col-xs-4">阅读 <?=$query['read_count']?></div>
        <div class="col-xs-4" id="like_test" onclick="click_ajax(<?=$query['id']?>)"><wb:like appkey="5ioQwE" type="simple"></wb:like></div>
        <div class="col-xs-4 text-right"><wb:share-button appkey="3285921784" addition="simple" type="button" pic="http%3A%2F%2F13loveme.com||http%3A%2F%2Fbaidu.com"></wb:share-button></div>
    </div>
</div>

<div class="container-fulid">
    <div class="row">
        <div class="col-md-3 col-md-offset-4">
            
                <?php if(in_array(Yii::$app->user->id,[10000,10001])):?>
                <wb:comments url="http://13loveme.com/date-today" width="auto" appkey="3285921784" ralateuid="5294143925" ></wb:comments>
            <?php endif;?>
        </div>


    </div>


</div>

    <div class="container active-comment hidden">
  <!--      <div class="row" style="background-color: #EF4450;border-radius: 5px;color:white;padding: 10px;margin-top: 10px;font-size: 16px;margin-bottom: 10px;">
            加微信客服约妹子：shisanyp13
        </div>-->
        <hr>
        <h5 class="text-center">留言区</h5>
        <div class="row write-comment">
        <span class="pull-right">
            <a href="<?=\yii\helpers\Url::to(['/show/show-news/comment','id'=>$query['id']])?>">写留言</a>
            <i class="glyphicon glyphicon-pencil"></i>
        </span>
        </div>

        <div class="row" style="background-color: #eee;">
            <?php foreach($comments as $comment):?>
                <div class="comment">

                    <div class="col-xs-2">
                        <img class="img-responsive center-block" src="<?=Yii::getAlias("@avatar")?>default/guest.png">
                    </div>
                    <div class="col-xs-10">
                        <div class="clearfix">
                            <h5 class="pull-left" style="margin-top: 0;">游客</h5>
                            <div class="comment-likes pull-right" onclick="return notes(<?=$comment['id']?>,this)">
                                <span class="glyphicon glyphicon-thumbs-up"></span>
                                <span style="margin-left: 5px;" class="comment-count"><?=$comment['likes']?></span>
                            </div>
                        </div>
                        <p>
                            <?=HtmlPurifier::process(Html::encode(strip_tags($comment['content'])))?>
                        </p>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>

<script>
    function notes(id,con){
        var cons = $(con);
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function stateChanged()
        {
            if (xhr.readyState==4 || xhr.readyState=="complete")
            {
                cons.children('.comment-count').html(xhr.responseText);
            }
        };
        xhr.open('get','/index.php/show/show-news/note?id='+id);
        xhr.send(null);
    }
    function click_ajax(id){

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function stateChanged()
        {
            if (xhr.readyState==4 || xhr.readyState=="complete")
            {
                $('.like_count').html(xhr.responseText);
            }
        };
        xhr.open('get','/index.php/show/show-news/ajax-week-click?id='+id);
        xhr.send(null);
    }

</script>
