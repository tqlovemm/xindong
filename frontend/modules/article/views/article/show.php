<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="initial-scale=1.0,maximum-scale=1.0, user-scalable=no, width=device-width" name="viewport">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title>
        <?= $type['typename']; ?>
    </title>
    <?=Html::cssFile('@web/css/article/article.css')?>
    <?=Html::cssFile('@web/css/article/dropload.css')?>
    <?=Html::jsFile('@web/css/article/jquery-2.1.4.js')?>
    <?=Html::jsFile('@web/css/article/dropload.min.js')?>
</head>
<body>
<div id="sx">
    <div class="content" style="word-wrap:break-word;">
        <h2 class="rich_media_title" id="activity-name" style="margin: 0px 0px 5px; padding: 0px; font-weight: 400; font-size: 24px; line-height: 1.4; zoom: 1;"><?= $cmodel->title; ?></h2>
        <p>
            <span id="post-date"  style="margin: 0px 8px 10px 0px; padding: 0px; display: inline-block; vertical-align: middle; font-size: 14px; color: rgb(153, 153, 153); max-width: none;"><?= date("Y-m-d",$cmodel->created_at); ?></span>&nbsp;
            <span style="margin: 0px 8px 10px 0px; padding: 0px; display: inline-block; vertical-align: middle; font-size: 14px; color: rgb(153, 153, 153); max-width: none;"><?= $username; ?></span>
        </p>
        <?= $cmodel->content;?>
    </div>
    <!--相关-->
    <?php if(isset($articlearr)){ ?>
    <div class="related">
        <h1 style="margin-bottom: 1;">RELATED</h1>
        <h3 style="margin-top: 1;" class="xg">相关内容</h3>
    </div>
    <ul class="list">
        <?php foreach ($articlearr as $vo): ?>
        <a style="color:#000;" href="<?= $url;?>/article/article/show?id=<?= $vo->id;?>&uid=<?= $uid;?>">
            <li>
                <img src='<?= Html::encode("{$vo->wimg}") ?>'>
                <div>
                    <h2 style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><?= Html::encode("{$vo->title}") ?></h2>
                    <span style="font-size: 10px;overflow : hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 2;  -webkit-box-orient: vertical;line-height: 14px;"><?= Html::encode("{$vo->miaoshu}") ?></span>
                    <p><img src='/images/time.png'><?= date('Y-m-d',$vo->created_at) ?><i></i><img src='/images/zan1.png'><?= $vo->wdianzan ?></p>
                </div>
            </li>
        </a>
        <?php endforeach; ?>
    </ul>
    <?php } ?>
    <div id="nav">
        <div class="botm">
            <?php if($dzres == 2){ ?>
                <span class="spanimg"><img src="/images/zan1.png" class="dz imgdz" /></span>
            <?php }else{ ?>
                <span class="spanimg"><img src="/images/zan2.png" class="dz2 imgdz" /></span>
            <?php } ?>
        </div>
        <div class="botm">
            <span class="spanimg"><img src="/images/comment.png" class="pl"/></span>
        </div>
        <div class="botm">
            <?php if($scres == 2){ ?>
                <span class="spanimg"><img src="/images/shoucang1.png" class="sc imgsc" /></span>
            <?php }else{ ?>
                <span class="spanimg"><img src="/images/shoucang2.png" class="sc2 imgsc" /></span>
            <?php } ?>
        </div>
    </div>
    <!--评论-->
    <div class="title">
        <h2>评论</h2>
    </div>
    <div class="reply-inner">

    </div>
</div>
<div style="height:38px;"></div>
<div class="weui_dialog_alert" id="dialog" style="display: none;">
    <div class="weui_mask"></div>
    <div class="weui_dialog" style="border: 1px solid #585858;">
        <div class="weui_dialog_hd"><strong class="weui_dialog_title">提示</strong></div>
        <div class="weui_dialog_bd notice_content">微信号不可为空</div>
        <div class="weui_dialog_ft">
            <a href="javascript:;" class="weui_btn_dialog primary iknow">确定</a>
        </div>
    </div>
</div>
<div class="weui_dialog_alert" id="plk" style="display: none;">
    <div class="weui_mask"></div>
    <div class="weui_dialog" style="border: 1px solid #585858;">
        <div class="weui_dialog_hd"><strong class="weui_dialog_title">评论</strong><strong class="clo">X</strong></div>
        <div class="weui_dialog_bd">
            <?php $form = ActiveForm::begin(['options' => ['id' => 'formpl']]); ?>
            <textarea name="content" onfocus="placeholder='';" onblur="this.placeholder='  写评论...';" class="plinput" value="" id="inputpl" placeholder="  写评论..."></textarea>
            <input type="hidden" name="aid" value="<?= $cmodel->id;?>" />
            <input type="hidden" name="created_id" value="<?= $uid;?>" />
            <?php ActiveForm::end(); ?>
        </div>
        <div class="weui_dialog_ft">
            <a href="javascript:;" class="weui_btn_dialog primary" id="sub">提交</a>
        </div>
    </div>
</div>
<script type="text/javascript">
    function btnClick($id) {
        window.webkit.messageHandlers.dianzan.postMessage($id);
    }
    function btnClick2($id) {
        window.webkit.messageHandlers.pinglun.postMessage($id);
    }
    function btnClick3($id) {
        window.webkit.messageHandlers.shoucang.postMessage($id);
    }
    function getnew(){
        var result = '';
        $.ajax({
            type: 'GET',
            url: "https://app.13loveme.com/v11/article-pls?aid="+<?= $cmodel->id;?>,
            dataType: 'json',
            success: function(data){
                var code = data.code;
                if(code == '200'){
                    result +=   '<dl class="reply-list">'
                        +'<dd class="operations-user"><div class="user-avatar">'
                        +'<img src="'+data.data[0].avatar+'">'
                        +'<span class="mod-mask mask"></span></div><div class="user-info">'
                        +'<div class="user-name">'+data.data[0].nickname+'</div>'
                        +'<div class="user-other">'
                        +'<span class="times">'+data.data[0].time+'</span>'
                        +'</div></div><div class="operations">'
//                                    +'<a href="javascript:" class="button-light">赞(56)</a>'
                        +'</div></dd><dt class="reply-content" style="font-size:16px;"><div class="current-content J_contentParent J_currentContent">'
                        +'<span class="short-content">'+data.data[0].content+'</span>'
                        +'</div></dt></dl>';
                    $('.reply-inner').prepend(result);
                }
            }
        });
    }
    $('.pl').click(function () {
        $('#inputpl').val("");
        $('#inputpl').blur;
        $('#plk').show();
    });
    $('.clo').click(function () {
        $('#plk').hide();
    });
    $('.dz2').click(function () {
        $('.notice_content').html('已经点赞过了!');
        $('#dialog').show();
    });
    $('.sc2').click(function () {
        $('.notice_content').html('已经收藏过了!');
        $('#dialog').show();
    });
    $('.iknow').click(function () {
        var res = $('.notice_content').html();
        $('#dialog').hide();
        if(res == '评论不可为空！'){
            $('#plk').show();
        }
    });
    $('#sub').click(function(){
        var res = $('.plinput').val();
        if (res==null||res=="") {
            $('.notice_content').html('评论不可为空！');
            $('#plk').hide();
            $('#dialog').show();
        }else {
            $.ajax({
                type: 'POST',
                url: "https://app.13loveme.com/v11/article-pls",
                data: $('#formpl').serialize(),
                dataType: 'json',
                success: function(data){
                    var code = data.code;
                    if(code == '200'){
                        getnew();
                    }
                    $('.notice_content').html(data.data);
                    $('#plk').hide();
                    $('#dialog').show();
                },
                error: function(){
                    alert('ajax error!');
                }
            });
        }
    });
    $('.sc').click(function () {
        $.ajax({
            type: 'POST',
            url: "https://app.13loveme.com/v11/article-collections",
            data: {userid:<?= $uid;?>, aid:<?= $cmodel->id;?>},
            dataType: 'json',
            success: function(data){
                var code = data.code;
                if(code == '200'){
                    btnClick3(1);
                }
                $('.imgsc').attr('src',"/images/shoucang2.png");
                $('.imgsc').attr('class',"sc2 imgsc");
                $('.notice_content').html(data.data);
                $('#dialog').show();
            },
            error: function(){
                alert('ajax error!');
            }
        });
    });
    $('.dz').click(function () {
        $.ajax({
            type: 'POST',
            url: "https://app.13loveme.com/v11/article-likes",
            data: {userid:<?= $uid;?>, aid:<?= $cmodel->id;?>},
            dataType: 'json',
            success: function(data){
                var code = data.code;
                if(code == '200'){
                    btnClick(1);
                }
                $('.imgdz').attr('src',"/images/zan2.png");
                $('.imgdz').attr('class',"dz2 imgdz");
                $('.notice_content').html(data.data);
                $('#dialog').show();
            },
            error: function(){
                alert('dzajax error!');
            }
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

