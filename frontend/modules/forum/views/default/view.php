<?php

$this->title = '详情';
function wordTime($time) {
    $time = (int) substr($time, 0, 10);
    $int = time() - $time;
    if ($int <= 2){
        $str = sprintf('刚刚', $int);
    }elseif ($int < 60){
        $str = sprintf('%d秒前', $int);
    }elseif ($int < 3600){
        $str = sprintf('%d分钟前', floor($int / 60));
    }elseif ($int < 86400){
        $str = sprintf('%d小时前', floor($int / 3600));
    }elseif ($int < 2592000){
        $str = sprintf('%d天前', floor($int / 86400));
    }else{
        $str = date('Y-m-d H:i:s', $time);
    }
    return $str;
}
$this->registerCss("

.list-group.list-inline li{width:22%;padding:10px;color:#bbb;}
.list-group.list-inline .glyphicon{color:#bbb;}
.thread-detail{max-width:768px;margin:auto;}
.thread-detail .row{margin:0;background-color: #fafafa;}
.thread-detail .list-group{margin-bottom:0;}
.thread-detail .row .col-xs-6{padding: 10px 10px;}
.thread-detail .row .col-xs-12{padding: 5px 5px 0 5px;}
.thread-detail .col-xs-6{padding:0;width:55.7%;}
.thread-detail .col-xs-4{padding:0;width:32.9%;}
.up_down_active{color:red !important;font-size:16px}
.good_comments {
    margin-right: 0;
    margin-left: 0;
    border-bottom: 1px solid #F6F2F2;
}
.good_comments .title {
    display: inline-block;
    position: relative;
    border-bottom-width: 2px;
    border-bottom-style: solid;
    z-index: 1;
    font-size: 14px;
    line-height: 16px;
    border-color: #FFD400;
    padding-bottom: 10.66667px;
    color:#000;
}
.myheaeder{background-color:black !important;color:#eee;padding:8px;}
.am-gallery{padding:0 !important;}
.am-gallery-overlay .am-gallery-item img{width:auto !important;}
");
$pre_url = Yii::$app->params['threadimg'];
$headimgurl = $thread['user']['headimgurl'];

?>
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" href="/css/auto/amazeui.min.css" />

<div class="thread-detail" style="color:#aaa;">
    <div class="row myheaeder">
        <div class="col-xs-2" style="padding-right: 0;padding-left:10px;text-align: left;">
            <a href="javascript:history.back();">
                <img  style="width: 20px;" src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png">
            </a>
        </div>
        <div class="col-xs-8" style="text-align: center"><?=$this->title?></div>
        <div class="col-xs-2" style="padding-left:0;text-align: right;"><a style="color:#eee" href="/forum/default/report?tid=<?=$thread['tid']?>">举报</a></div>
    </div>
    <div class="row">
        <div class="col-xs-6"><img class="img-circle" style="width: 40px;" src="<?=$headimgurl?>">&nbsp;&nbsp;&nbsp; <?=$thread['user']['username']?></div>
    </div>

    <div data-am-widget="gallery" class="row am-gallery am-avg-sm-2 am-avg-md-3 am-avg-lg-4 am-gallery-overlay clearfix" data-am-gallery="{ pureview: true }" >
        <?php if(count($thread['img'])==1):?>
            <?php foreach ($thread['img'] as $key=>$img):?>
                <a style="padding: 0 0 10px 10px;" href="<?=$img['img']?>" class="col-xs-6 am-gallery-item">
                    <img class="img-responsive" src="<?=$pre_url.$img['img']?>">
                </a>
            <?php endforeach;?>
        <?php elseif(in_array(count($thread['img']),[2,4])):?>
            <?php foreach ($thread['img'] as $key=>$img):?>
                <a href="<?=$img['img']?>" class="col-xs-6 am-gallery-item" style="<?php if(in_array($key,[1,3])){echo 'float:right;';}?>;height: 130px;margin-bottom: 2px;overflow: hidden;padding:0;">
                    <img class="img-responsive" src="<?=$pre_url.$img['img']?>">
                </a>
            <?php endforeach;?>
        <?php elseif(in_array(count($thread['img']),[3,5,6,7,8,9])): ?>
            <?php foreach ($thread['img'] as $key=>$img):?>
                <a href="<?=$headimgurl.$img['img']?>" class="col-xs-4 am-gallery-item" style="<?php if(in_array($key,[1,4,7])){echo 'margin:0 0.6%;';}?>;<?php if(in_array($key,[2,5,8])){echo 'float:right;';}?>;height: 105px;margin-bottom: 2px;overflow: hidden;">
                    <img class="img-responsive" src="<?=$pre_url.$img['img']?>">
                </a>
            <?php endforeach;?>
        <?php endif;?>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?=\yii\helpers\Html::encode($thread['content'])?>
        </div>
    </div>
    <div class="row" style="background-color: #fcfcfc;margin-bottom: 10px;">
        <ul class="list-group list-inline" style="padding-left: 10px;">
            <li class="thumbs_up" onclick="thumbs_total(<?=$thread['tid']?>,1,this)"><span class="glyphicon glyphicon-thumbs-up <?php if($thread['thumbs']['type']==1){echo 'up_down_active';}?>"></span> <span class="count"><?=$thread['thumbsup_count']?></span></li>
            <li class="thumbs_down" onclick="thumbs_total(<?=$thread['tid']?>,2,this)"><span class="glyphicon glyphicon-thumbs-down <?php if($thread['thumbs']['type']==2){echo 'up_down_active';}?>"></span> <span class="count"><?=$thread['thumbsdown_count']?></span></li>
            <li><a href="/forum/default/push-comments?tid=<?=$thread['tid']?>"><span class="glyphicon glyphicon-comment"></span> <span><?=count($thread['comments'])?></span></a></li>
        </ul>
    </div>
    <div class="comments-list" style="padding: 0 10px;background-color: #fafafa;">
    <?php foreach ($comments->orderBy('pre_anecdote_thread_comments.thumbsup_count desc')->limit(2)->asArray()->all() as $key=>$comment): if($key==0):?>
        <h1 class="good_comments" data-reactid=".0.0.2.0.0"><span class="title G-canBeZoom" data-reactid=".0.0.2.0.0.0">精彩评论</span></h1>
        <?php endif;?>
        <div class="row" style="padding:10px 0;border-bottom: 1px solid #F6F2F2;">
            <div class="col-xs-1" style="padding: 0 0 0 0;"><img class="img-responsive img-circle" src="<?=$comment['user']['headimgurl']?>"></div>
            <div class="col-xs-11" style="padding: 0 0 0 10px;">
                <div class="row">
                    <div class="col-xs-6" style="padding: 0"><?=$comment['user']['username']?></div>
                    <div class="col-xs-6" style="padding: 0 10px;text-align: right;">
                        <span class="glyphicon glyphicon-thumbs-up <?php if($comment['thumbs']['where'] == 2 ){echo 'up_down_active';}?>" onclick="return comment_thumbs_total(<?=$comment['cid']?>,this)"></span> <span class=""><?=$comment['thumbsup_count']?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12" style="padding: 0;color:#6d6d6d;font-size: 14px;">
                        <a href="/forum/default/push-comments?tid=<?=$comment['cid']?>&level=2&to_user_id=<?=$comment['user']['user_id']?>">
                            <p style="margin-bottom: 0;padding:3px 0"><?=\yii\helpers\Html::encode($comment['comment'])?></p>
                        </a>
                        <div class="row" style="margin-top: 5px;background-color: #eee;">
                            <?php foreach ($comment['cos'] as $list):
                                $user_info = new \frontend\modules\forum\models\AnecdoteUsers();
                                $username = $user_info::findOne(['user_id'=>$list['user_id']]);
                                $to_username = $user_info::findOne(['user_id'=>$list['to_user_id']]);
                                $userheadimgurl = $username->headimgurl;
                                ?>
                                <div class="col-xs-12" style="padding:5px;border-bottom:1px dotted #e0dddd;">
                                    <a href="/forum/default/push-comments?tid=<?=$list['cid']?>&level=2&to_user_id=<?=$list['user_id']?>" style="display: block;">
                                        <p style="margin-bottom: 0;font-size: 12px;"><img style="width: 20px;" class="img-circle" src="<?=$userheadimgurl?>"> <?=$username->username?>回复<?=$to_username->username?>：<?= \yii\helpers\Html::encode($list['content'])?></p>
                                    </a>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <small><?php echo wordTime($comment['created_at'])?></small>
                </div>
            </div>
        </div>

    <?php endforeach;?>
    </div>
    <div class="comments-list" style="padding: 0 10px;background-color: #fafafa;">
    <?php foreach ($comments->orderBy('pre_anecdote_thread_comments.created_At desc')->limit(10)->asArray()->all() as $key=>$comment): if($key==0):?>
        <h1 class="good_comments" style="margin: 0;" data-reactid=".0.0.2.0.0"><span class="title G-canBeZoom" data-reactid=".0.0.2.0.0.0">全部评论</span></h1>
    <?php endif;?>
        <div class="row" style="padding:10px 0;border-bottom: 1px solid #ebebeb;">
            <div class="col-xs-1" style="padding: 0 0 0 0;"><img class="img-responsive img-circle" src="<?=$comment['user']['headimgurl']?>"></div>
            <div class="col-xs-11" style="padding: 0 0 0 10px;">
                <div class="row">
                    <div class="col-xs-6" style="padding: 0"><?=$comment['user']['username'];?></div>
                    <div class="col-xs-6" style="padding: 0 10px;text-align: right;">
                        <span class="glyphicon glyphicon-thumbs-up <?php if($comment['thumbs']['where'] == 2){echo 'up_down_active';}?>" onclick="return comment_thumbs_total(<?=$comment['cid']?>,this)"></span>
                        <span class=""><?=$comment['thumbsup_count']?></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12" style="padding: 0;color:#6d6d6d;font-size: 14px;"onclick="log()">
                        <a href="/forum/default/push-comments?tid=<?=$comment['cid']?>&level=2&to_user_id=<?=$comment['user']['user_id']?>">
                            <p style="margin-bottom: 0;padding:3px 0"><?=\yii\helpers\Html::encode($comment['comment'])?></p>
                        </a>
                        <div class="row" style="margin-top: 5px;background-color: #eee;">
                            <?php foreach ($comment['cos'] as $list):
                                $user_info = new \frontend\modules\forum\models\AnecdoteUsers();
                                $username = $user_info::findOne(['user_id'=>$list['user_id']]);
                                $to_username = $user_info::findOne(['user_id'=>$list['to_user_id']]);
                                $userheadimgurl = $username->headimgurl;
                                ?>
                                <div class="col-xs-12" style="padding:5px;border-bottom:1px dotted #e0dddd;">
                                    <a href="/forum/default/push-comments?tid=<?=$list['cid']?>&level=2&to_user_id=<?=$list['user_id']?>" style="display: block;">
                                        <p style="margin-bottom: 0;font-size: 12px;"><img style="width: 20px;" class="img-circle" src="<?=$userheadimgurl?>"> <?=$username->username?>回复<?=$to_username->username?>：<?= \yii\helpers\Html::encode($list['content'])?></p>
                                    </a>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <small><?php echo wordTime($comment['created_at'])?></small>
                </div>
            </div>
        </div>
    <?php endforeach;?>
    </div>
    <div class="row" style="margin-bottom: 40px;">
        <div style="position: fixed;z-index:99;bottom:0;left:0;padding:5px 0;background-color: #fafafa;width: 100%;box-shadow: 0 0 3px #ddd;">
            <a href="/forum/default/push-comments?tid=<?=$thread['tid']?>" class="center-block" style="width: 90%;display: block;padding:5px 15px;background-color: #eee;border-radius: 50px;color:#aaa;">
                <span class="glyphicon glyphicon-pencil" style="margin-right: 10px;color:orange;"></span>期待你的留言
            </a>
        </div>
    </div>
</div>
<script>

    function thumbs_total(tid,type,content) {

        var conx = $(content);
        $.get('/forum/default/thumbs?tid=' + tid + '&type=' + type, function (data) {

            if(data == 4){
                if(confirm('请先登陆')){
                    window.location.href='/forum/default/choice-login';
                }else{
                    return false;
                }

            }
            var up_down = $.parseJSON(data);

            if (type == 1) {
                conx.children('.count').html(up_down.up);
                conx.siblings('.thumbs_down').children('.count').html(up_down.down);
                if (up_down.status == 10) {
                    conx.children('.glyphicon').removeClass('up_down_active');
                } else {
                    conx.children('.glyphicon').addClass('up_down_active');
                    conx.siblings('.thumbs_down').children('.glyphicon').removeClass('up_down_active');
                }
            } else {
                conx.children('.count').html(up_down.down);
                conx.siblings('.thumbs_up').children('.count').html(up_down.up);
                if (up_down.status == 10) {//.status == 10
                    conx.children('.glyphicon').removeClass('up_down_active');
                } else {
                    conx.children('.glyphicon').addClass('up_down_active');
                    conx.siblings('.thumbs_up').children('.glyphicon').removeClass('up_down_active');
                }
            }
        });

    }
    function comment_thumbs_total(cid,content) {
        var conx = $(content);
            $.get('/forum/default/comment-thumbs?cid='+cid,function (msg) {

                if(msg == 4){
                    if(confirm('请先登陆')){
                        window.location.href='/forum/default/choice-login';
                    }
                }

                if(msg==false){
                    alert('您已经点赞');
                }

                var upcount = $.parseJSON(msg);

                conx.siblings('span').html(upcount.up);
                if(upcount.status==10){
                    conx.addClass('up_down_active');
                    //window.location.reload();
                }else {
                    conx.removeClass('up_down_active');
                }
            });


    }
</script>
<script src="/js/datejs/amazeui.js"></script>