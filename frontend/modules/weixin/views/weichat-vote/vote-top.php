<?php
$session = Yii::$app->session;
if(!$session->isActive){
    $session->open();
}
$this->title = "男神女神排行榜";
$dinyue_userinfo= new \frontend\models\DinyueWeichatUserinfo();

$this->registerCss('
    .nav-tabs-top{width:100%;z-index:9;}
    #topTab > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus{background-color: #22222E !important;color:#fff !important;}
    .weicaht-note {width: 20%;padding: 6px 10px;border-radius: 4px;font-size: 14px;z-index: 9;background-color: rgb(231,0,108);border: none;color: #fff;box-shadow: 0 0 7px #d7d7d7;}
    .vote-top-box{background-color: #fff;padding:10px;margin-bottom: 10px;position: relative;}
    .vote-top-icon{width: 80px;position: absolute;top:10px;left:10px;z-index:8;}
    .vote-top-img-a{position: relative;display: block;}
    .vote-top-img-a span{position: absolute;right: 5px;top:5px;background-color: #fff;padding:5px 10px;color:gray;box-shadow: 0 0 4px #aaa;color:rgb(231,0,108);font-weight:500;border-radius:3px;}
    .vote-top-img-a img{border-radius: 4px;}
    .nav-tabs > li > a{border-radius:0 !important;}
    #topTab{background-color: #fff;margin-bottom: 10px;margin-top:10px;}
    #topTab > .woman.active > a, .nav-tabs > .woman.active > a:hover, .nav-tabs > .woman.active > a:focus{background-color:#F74D8B !important;}
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
        <li>
            <a href="vote-man">男生 <img style="width: 25px;margin-top: -4px;" src="/images/vote/906898231657870808.png"></a>
        </li>
        <li style="border-right: 1px solid #eee;border-left: 1px solid #eee;">
            <a href="vote-woman">女生 <img style="width: 25px;margin-top: -6px;" src="/images/vote/23587436294114443.png"></a>
        </li>
        <li class="active">
            <a href="vote-top" style="position: relative;">
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
            <?php foreach ($model_woman as $key=>$woman_top):
                if($key>=5)
                    break;
                ?>
                <div class="vote-top-box">
                    <img class="vote-top-icon" src="/images/vote/woman<?=$key+1?>.png">
                    <a href="sign-detail?id=<?=$woman_top['id']?>" class="vote-top-img vote-top-img-a">
                        <span>编号:<?=$woman_top['id']?></span>
                        <img class="img-responsive center-block" src="<?=$woman_top['img']['img']?>">
                    </a>
                    <div class="row" style="padding: 10px;margin: 0;">
                        <div class="col-xs-6 note-count"><?=$woman_top['vote_count']?></div>
                        <?php if(empty($dinyue_userinfo::findOne(['unionid'=>$session->get('vote_01_openid')]))):?>
                            <a class="col-xs-6" style="padding:0;text-align: right;" data-lightbox="d" data-title="请关注微信订阅号进行投票" href="/images/weixin/149129585220305657.jpg">
                                <span class="weicaht-note">投票</span>
                            </a>
                        <?php else:?>
                            <div class="col-xs-6" style="padding:0;text-align: right;" data-sex="<?=$woman_top['sex']?>" onclick="vote_notes(<?=$woman_top['id']?>,this)">
                                <span class="weicaht-note">投票</span>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
        <div class="tab-pane fade" id="mans">
            <?php foreach ($model_man as $k=>$man_top):
                if($k>=5)
                    break;

                ?>

                <div class="vote-top-box">
                    <img class="vote-top-icon" src="/images/vote/man<?=$k+1?>.png">
                    <a href="sign-detail?id=<?=$man_top['id']?>" class="vote-top-img vote-top-img-a">
                        <span>编号:<?=$man_top['id']?></span>
                        <img class="img-responsive center-block" src="<?=$man_top['img']['img']?>">
                    </a>
                    <div class="row" style="padding: 10px;margin: 0;">
                        <div class="col-xs-6 note-count"><?=$man_top['vote_count']?></div>
                        <?php if(empty($dinyue_userinfo::findOne(['unionid'=>$session->get('vote_01_openid')]))):?>
                            <a class="col-xs-6" style="padding:0;text-align: right;" data-lightbox="d" data-title="请关注微信订阅号进行投票" href="/images/weixin/149129585220305657.jpg">
                                <span class="weicaht-note">投票</span>
                            </a>
                        <?php else:?>
                            <div class="col-xs-6" style="padding:0;text-align: right;" data-sex="<?=$man_top['sex']?>" onclick="vote_notes(<?=$man_top['id']?>,this)">
                                <span class="weicaht-note">投票</span>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>