<?php
use yii\widgets\LinkPager;
$session = Yii::$app->session;
if(!$session->isActive){
    $session->open();
}
$this->title = "新春ID照";
$this->registerCssFile("@web/css/note/base.css");
$this->registerCssFile("@web/css/note/style.css");
$good = new \frontend\modules\test\models\NewYearGood();
$this->registerCss("
    .nav-tabs-top{width:100%;z-index:9;}
    .contact{display:none;}
    .wall-column{padding-bottom:0;margin-bottom:80px; !important;}
    .container-fluid{padding:0;margin:0;}
    .col-xs-4{padding:0;margin:0 auto;}
    .col-xs-4 a{padding:0;margin:0;}
    .nav-tabs > li > a{border-radius:0;text-align:center;color:#bbb;font-size:18px; !important;}
    #topTab > .woman.active > a, .nav-tabs > .woman.active > a:hover, .nav-tabs > .woman.active > a:focus{color:#CCCCC1;}
    .footer-list{position: fixed;z-index: 999;bottom:0;width: 100%;background-color: #22222E;text-align: center;padding:6px 0;}
    .footer-list a{padding:6px 0;color:#fff;}
    .article{margin-bottom:10px;padding:0 6px 0 8px;text-align:center}
    .center-block{margin-bottom:50px}
    .weicaht-note{padding:3px 0;display:block;font-size: 20px;text-align:center;background-color:#22222E;border-radius: 3px;margin-top:3px;}
    .abd-active{color:#F74D8B;font-size:20px;}
");
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
            $('.contact').css('display','block');
        }
        if($(obj).offset().top<=initPos){
            $(obj).css('position','static');
            $(obj).removeClass('nav-tabs-shadow');
            $('.contact').css('display','none');
        }
    });
");
?>
<div class="nav-tabs-top">
    <a class="contact" href="/contact">
        <img class="img-responsive" src="<?=Yii::getAlias('@web')?>/images/vote/669179008377191553.png">
    </a>
    <ul id="myTab" class="nav nav-tabs nav-tabs-man" style="margin-bottom: 10px;background-color: #fff;">
        <li class="active col-xs-4" >
            <a href="man">男生 <img style="width: 25px;margin-top: -4px;" src="/images/vote/906898231657870808.png"></a>
        </li>
        <li class="col-xs-4">
            <a href="woman">女生 <img style="width: 25px;margin-top: -6px;" src="/images/vote/23587436294114443.png"></a>
        </li>
        <li class="col-xs-4">
            <a href="top" style="position: relative;">排行榜<img style="width: 26px;position: absolute;top:-6px;right: 3px;" src="/images/vote/huangguan.png"></a>
        </li>
    </ul>
</div>
<div id="myTabContent" class="tab-content" style="margin-bottom: 100px;min-height: 300px;">
    <div class="tab-pane fade in active" id="man">
        <ul class="wall">
            <?php foreach($model as $man):?>
                <li class="article">
                    <h5 style="color:gray;text-align: left">参赛编号：<?=$man['id']?>号</h5>
                    <a href="center?id=<?=$man['id']?>">
                            <img src="<?=$man['img']['thumb']?>"/>
                    </a>
                    <div class="note-count note-padding"> </div>
                        <?php if($subscribe !== 1):?>
                            <div style="padding: 0;margin: 0;font-size: 14px;">总票数：<span class="note-count note-padding"><?=$man['num'];?></span></div>
                        <a class="weicaht-note" style="color: #fff" data-lightbox="d" data-title="请关注微信订阅号进行投票" href="/images/weixin/8505.jpg">
                            <span class="glyphicon glyphicon-heart"></span> 投票
                        </a>
                        <?php else:?>
                            <div style="padding: 0;margin: 0;font-size: 14px;">总票数：<span class="note-count note-padding"><?=$man['num']?></span></div>
                        <div class="weicaht-note" style="color: #fff">
                            <?php $model = $good::findOne(['da_id'=>$man['id'],'sayGood'=>$session->get('openId')]);?>
                            <span class="glyphicon glyphicon-heart <?php if($model) echo 'abd-active';?>" onclick="vote_notes(<?=$man['id']?>,'<?=$session->get('openId')?>',this)"></span>
                             投票
                        </div>
                        <?php endif;?>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
</div>
<div class="text-center"><?=LinkPager::widget(['pagination'=>$pages,'firstPageLabel'=>"首页",'lastPageLabel'=>"末页","prevPageLabel"=>"上页","nextPageLabel"=>"下页","maxButtonCount"=>0])?></div>

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


<?php
$this->registerJs("
        $('.wall').jaliswall({ item: '.article' });
    ");
?>


