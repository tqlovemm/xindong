<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title>
        十三说--<?= $cmodel->title; ?>
    </title>
    <?=Html::cssFile('@web/css/article/article.css')?>
    <?=Html::cssFile('@web/css/article/dropload.css')?>
    <?=Html::jsFile('@web/css/article/jquery-2.1.4.js')?>
    <?=Html::jsFile('@web/css/article/dropload.min.js')?>
</head>
<style>
    #nav { width:100%; background:#F7F7FA; position:fixed;left:0;bottom: 0px;height: 7%;z-index: 99999; }
    .plinput{
        float:left;
        display: block;
        width: 70%;
        margin-top: 1.5%;
        margin-left: 2%;
        height: 75%;
        font-size: 14px;
        line-height: 1.42857143;
        background-color: #E6E6E6;
        border: 0px solid #ccc;
    }
    .pl{
        float:left;
        display: block;
        margin-top: 1.5%;
        margin-left: 3%;
        height: 75%;
    }
    .sc{
        float:right;
        display: block;
        margin-top: 1.5%;
        margin-right: 2%;
        height: 75%;
    }
</style>
<body>
<div id="nav" style="display: none;">
        <?php $form = ActiveForm::begin(); ?>
        <input type="text" name="content" class="plinput" placeholder="  写评论..." onfocus="this.placeholder=''" onblur="this.placeholder='  写评论...'"/>
        <input type="hidden" name="aid" value="<?= $cmodel->id;?>" />
        <input type="image" src="/images/comment.png" class="pl" alt="submit"/>
        <img src="/images/like.png" class="sc" />
        <?php ActiveForm::end(); ?>
</div>
<div id="sx">
    <div class="content">
        <h2 class="rich_media_title" id="activity-name" style="margin: 0px 0px 5px; padding: 0px; font-weight: 400; font-size: 24px; line-height: 1.4; zoom: 1;"><?= $cmodel->title; ?></h2>
        <p>
            <span id="post-date"  style="margin: 0px 8px 10px 0px; padding: 0px; display: inline-block; vertical-align: middle; font-size: 14px; color: rgb(153, 153, 153); max-width: none;"><?= date("Y-m-d",$cmodel->created_at); ?></span>&nbsp;
            <span style="margin: 0px 8px 10px 0px; padding: 0px; display: inline-block; vertical-align: middle; font-size: 14px; color: rgb(153, 153, 153); max-width: none;"><?= $username; ?></span>
        </p>
        <?= $cmodel->content;?>
    </div>
    <!--相关-->
    <div class="related">
        <h1 style="margin-bottom: 1;">RELATED</h1>
        <h3 style="margin-top: 1;">相关内容</h3>
    </div>
    <ul class="list">
        <?php foreach ($articlearr as $vo): ?>
            <li>
                <img src='<?= Html::encode("{$vo->wimg}") ?>'>
                <div>
                    <h2><?= Html::encode("{$vo->title}") ?></h2>
                    <p><img src='/images/time.png'><?= date('Y-m-d',$vo->created_at) ?><i></i><img src='/images/like.png'><?= $vo->wdianzan ?></p>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <!--评论-->
    <div class="title">
        <h2>评论</h2>
    </div>
    <div class="reply-inner">

    </div>
</div>
<div style="height:38px;"></div>
<script type="text/javascript">
$(function(){
    var title = $(".related").offset().top-150;
    var oDiv = document.getElementById("nav");
    $(window).scroll(function(){
        var this_scrollTop = $(this).scrollTop();
        if(this_scrollTop>title){
            oDiv.style = "display: inline;"
        }else {
            oDiv.style = "display: none;"
        }
    });
    $(".sc").click(function(){
        window.webkit.messageHandlers.abcdefg.postMessage('test');
    });
});
</script>
<script>
    $(function(){
        var page = 0;
        $('#sx').dropload({
            scrollArea : window,
            loadUpFn : function(me){
                location.reload();
            },
            loadDownFn : function(me){
                page++;
                var result = '';
                $.ajax({
                    type: 'GET',
                    url: "<?= $url;?>/article/article/getcomment?page="+page+"&aid=<?= $cmodel->id;?>",
                    dataType: 'json',
                    success: function(data){
                        var arrLen = data.length;
                        if(arrLen > 0){
                            for(var i=0; i<arrLen; i++){
                                result +=   '<dl class="reply-list">'
                                    +'<dd class="operations-user"><div class="user-avatar">'
                                    +'<img src="'+data[i].avatar+'">'
                                    +'<span class="mod-mask mask"></span></div><div class="user-info">'
                                    +'<div class="user-name">'+data[i].nickname+'</div>'
                                    +'<div class="user-other">'
                                    +'<span class="times">'+data[i].time+'</span>'
                                    +'</div></div><div class="operations">'
//                                    +'<a href="javascript:" class="button-light">赞(56)</a>'
                                    +'</div></dd><dt class="reply-content" style="font-size:16px;"><div class="current-content J_contentParent J_currentContent">'
                                    +'<span class="short-content">'+data[i].content+'</span>'
                                    +'</div></dt></dl>';
                            }
                        }else{
                            me.lock();
                            me.noData();
                        }
                        setTimeout(function(){
                            $('.reply-inner').append(result);
                            me.resetload();
                        },1000);
                    },
                    error: function(xhr, type){
                        alert('Ajax error!');
                        me.resetload();
                    }
                });
            }
        });
    });
</script>
</body>
</html>

