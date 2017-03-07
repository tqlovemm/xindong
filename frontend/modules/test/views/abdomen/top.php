<?php
$session = Yii::$app->session;
if(!$session->isActive){
    $session->open();
}
$this->title = "男神女神排行榜";
$good = new \frontend\modules\test\models\WeichatDazzleGood();
$this->registerCss('
    .nav-tabs-top{width:100%;z-index:9;}
    #topTab > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus{background-color: #22222E !important;color:#fff !important;}
    .weicaht-note {display: block;margin-top:5px;color:#C1C1C1;background-color:#22222E;text-align:center;padding: 3px 5px 0;border-radius: 3px;font-size: 20px;z-index: 9;}
    .vote-top-box{background-color: #fff;padding:10px;margin-bottom: 10px;position: relative;}
    .vote-top-icon{width: 80px;position: absolute;top:10px;left:10px;z-index:8;}
    .vote-top-img-a{position: relative;display: block;}
    .vote-top-img-a span{position: absolute;right: 5px;top:5px;background-color: #fff;padding:5px 10px;color:gray;box-shadow: 0 0 4px #aaa;color:rgb(231,0,108);font-weight:500;border-radius:3px;}
    .vote-top-img-a img{border-radius: 4px;}
    .nav-tabs > li > a{border-radius:0;text-align:center; !important;}
    #topTab{background-color: #fff;margin-bottom: 10px;margin-top:10px;}
    #topTab > .woman.active > a, .nav-tabs > .woman.active > a:hover, .nav-tabs > .woman.active > a:focus{background-color:#F74D8B !important;}
    .col-xs-4,.col-xs-4 a{padding:0;margin:0}
    .footer-list{position:fixed;z-index:999;background-color:#22222E;bottom:0;width: 100%;text-align: center;padding:6px 0;}
    .footer-list a{padding:6px 0;color:#fff;}
    .container-fluid{padding:0}
    .abd-active{color:#F74D8B;font-size:20px;}
');
$this->registerJs("

    var obj = '.nav-tabs-top';
    var initPos = $(obj).offset().top;
    var distance = 0;

  	$(window).scroll(function(event) {
        var objTop = $(obj).offset().top - $(window).scrollTop();
        if(objTop<=distance){
            $(obj).css('position','fixed');
            $(obj).css('top',distance+'px');
            $(obj).css('max-width',470+'px');
            $(obj).addClass('nav-tabs-shadow');
            $('#topTab').css('margin-top',0);
        }
        if($(obj).offset().top<=initPos){
            $(obj).css('position','static');
            $(obj).removeClass('nav-tabs-shadow');
            $('#topTab').css('margin-top','10px');
        }
    });
");

?>
<div class="nav-tabs-top">
    <ul class="nav nav-tabs" style="background-color: #fff; ">
        <li class="col-xs-4">
            <a href="man">男生 <img style="width: 25px;margin-top: -4px;" src="/images/vote/906898231657870808.png"></a>
        </li>
        <li class="col-xs-4" style="border-right: 1px solid #eee;border-left: 1px solid #eee;">
            <a href="woman">女生 <img style="width: 25px;margin-top: -6px;" src="/images/vote/23587436294114443.png"></a>
        </li>
        <li class="active col-xs-4">
            <a href="top" style="position: relative;">
                排行榜
                <img style="width: 26px;position: absolute;top:-6px;right: 3px;" src="/images/vote/huangguan.png">
            </a>
        </li>
    </ul>
    <ul id="topTab" class="nav nav-tabs">
        <li class="woman active" style="width: 50%;"><a href="#womans" data-toggle="tab">女神榜</a></li>
        <li class="man" style="width: 50%;"><a href="#mans" data-toggle="tab">男神榜</a></li>
    </ul>
</div>
<div style="padding-bottom: 60px;">
    <div id="topTabContent" class="tab-content" style="min-height: 300px;">
        <div class="tab-pane fade in active" id="womans">
            <?php
            foreach($woman as $key=>$list):
                if($key>=5)
                    break;
                ?>
                <div class="vote-top-box">
                    <img class="vote-top-icon" src="/images/vote/woman<?=$key+1?>.png">
                    <a href="center?id=<?=$list['id']?>" class="vote-top-img vote-top-img-a">
                        <span>编号:<?=$list['id']?></span>
                        <img class="img-responsive center-block" src="<?=$list['img']['thumb']?>">
                    </a>
                    <div class="row" style="padding: 0px;margin:0;">
                        <?php if($subscribe !== 1):?>
                            <a class="weicaht-note" data-lightbox="d" data-title="请关注微信订阅号进行投票" href="/images/weixin/8505.jpg">
                                <span class="glyphicon glyphicon-thumbs-up" style="padding-top: 3px;"></span> <span class="note-count note-padding"><?=$list['num']?></span>
                            </a>
                        <?php else:?>
                            <div class="weicaht-note">
                                <?php $model = $good::findOne(['da_id'=>$list['id'],'sayGood'=>$session->get('openId')]);?>
                                <span class="glyphicon glyphicon-thumbs-up <?php if($model){echo 'abd-active';}?>" onclick="vote_notes(<?=$list['id']?>,'<?=$session->get('openId')?>',this)"> </span>
                                <span class="note-count note-padding"><?=$list['num']?></span>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="tab-pane fade" id="mans">
            <?php foreach ($man as $key=>$list):
                if($key>=5)
                    break;
                ?>
                <div class="vote-top-box">
                    <img class="vote-top-icon" src="/images/vote/man<?=$key+1?>.png">
                    <a href="center?id=<?=$list['id']?>" class="vote-top-img vote-top-img-a">
                        <span>编号:<?=$list['id']?></span>
                        <img class="img-responsive center-block" src="<?=$list['img']['thumb']?>">
                    </a>
                    <div class="row" style="padding: 0px;margin:0;">
                        <?php if($subscribe !== 1):?>
                            <a class="weicaht-note" data-lightbox="d" data-title="请关注微信订阅号进行投票" href="/images/weixin/8505.jpg">
                                <span class="glyphicon glyphicon-thumbs-up" style="padding-top: 3px;"></span> <span class="note-count note-padding"><?=$list['num']?></span>
                            </a>
                        <?php else:?>
                            <div class="weicaht-note">
                                <?php $model = $good::findOne(['da_id'=>$list['id'],'sayGood'=>$session->get('openId')]);?>
                                <span class="glyphicon glyphicon-thumbs-up <?php if($model){echo 'abd-active';}?>" onclick="vote_notes(<?=$list['id']?>,'<?=$session->get('openId')?>',this)"> </span>
                                <span class="note-count note-padding"><?=$list['num']?></span>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<div class="wrapper footer-list" style="max-width: 470px;">
    <a class="col-xs-4" href="http://mp.weixin.qq.com/s?__biz=MzI1MTEyMDI0Mw==&mid=2667464138&idx=1&sn=f74b546062babcb3fdd76738ec5c2304&chksm=f2fd3ad6c58ab3c028f7258e6342b0ed06e33e9a6a1e0aefbd4ba1348266d81938e75db2ccc5&scene=1&srcid=09109c1SKV9dl3B8K54Y2t7f#wechat_redirect">活动细则</a>
    <a class="col-xs-4" href="join?id=<?=$session->get('id')?>" style="box-shadow: 0 0 6px rgb(231,0,108);border-radius: 30px;font-size: 16px;font-weight: bold;background-color: #fff;color:rgb(231,0,108);">我要参赛</a>
    <a class="col-xs-4" href="center?id= <?=$session->get('id')?>">个人中心</a>

</div>
<script>
    function vote_notes(id,openId,context){

        var cons = $(context);
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function stateChanged()
        {
            if (xhr.readyState==4 || xhr.readyState=="complete")
            {
                cons.siblings('.note-count').html(xhr.responseText);
                cons.addClass('abd-active');
            }
        };
        xhr.open('get','abd-click?id='+id+'&openId='+openId);
        xhr.send(null);
    }
</script>