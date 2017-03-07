<?php
use yii\widgets\LinkPager;
$session = Yii::$app->session;
if(!$session->isActive){
    $session->open();
}
$this->title = "最美ID照-女神评选";
$voteusergood = new \frontend\modules\test\models\VoteUserGood();
$this->registerCssFile("@web/css/note/base.css");
$this->registerCssFile("@web/css/note/style.css");
$this->registerCss("
    .nav-tabs-top{width:100%;z-index:9;}
    .article{margin:10px 0;padding:0 6px;}
    .wall-column{margin-bottom:100px;}
    .contact{display:none;}
    .weicaht-note {display:block;color: #C1C1C1;background:#22222E;margin-top:3px;text-align:center;padding: 3px 0px;border-radius: 3px;font-size: 20px;z-index: 9;border: none;}
    .container-fluid{padding:0px;}
    .text-center{margin-right:3%;margin-bottom:50px;}
    .footer-list{position: fixed;z-index: 999;bottom:0;width: 100%;background-color: #22222E;text-align: center;padding:6px 0;}
    .footer-list a{padding:6px 0;color:#fff;}
    .vote-active{color:#F74D8B;font-size:20px}
    .box-shadow{  -webkit-box-shadow: 2px 2px 2px #C1C1C1;  -moz-box-shadow: 2px 2px 2px #C1C1C1;  box-shadow: 2px 2px 2px #C1C1C1;  }
    .center-block{margin-bottom:50px}
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
<div class="nav-tabs-top" >
    <a class="contact" href="/contact">
        <img class="img-responsive" src="<?=Yii::getAlias('@web')?>/images/vote/669179008377191553.png">
    </a>
    <ul id="myTab" class="nav nav-tabs nav-tabs-man text-center" style="margin-bottom: 0px;background-color: #fff;">
        <li style="width: 33.33%">
            <a href="man">男生 <img style="width: 25px;margin-top: -4px;" src="/images/vote/906898231657870808.png"></a>
        </li>
        <li class="active box-shadow" style="border-left: 1px solid #eee; width: 33.33%">
            <a href="women" style="margin-right: 0;">女生 <img style="width: 25px;margin-top: -6px;" src="/images/vote/23587436294114443.png"></a>
        </li>
        <li style="border-right: 1px solid #eee;border-left: 1px solid #eee; width: 33.33%">
            <a href="top" style="position: relative;">排行榜<img style="width: 26px;position: absolute;top:-6px;right: 3px;" src="/images/vote/huangguan.png"></a>
        </li>
    </ul>
</div>
<div id="myTabContent" class="tab-content" style="min-height: 300px;">
    <div class="tab-pane fade in active" id="women">
        <ul class="wall" >
            <?php foreach ($model as $key=>$item):?>
                <li class="article" >
                    <h5 style="margin-top: 0;color:gray;text-align: left;padding-top: 5px;;">参赛编号：<?=$item['id']?>号</h5>
                    <a href="center?Id=<?=$item['id']?>">
                        <?php foreach ($item['imgs'] as $k=>$list):
                            if($k==1) break; ?>
                            <img src="<?=$list['thumb']?>"/>
                        <?php endforeach;?>
                    </a>

                    <?php if($subscribe != 1):?>
                        <a class="weicaht-note" data-lightbox="d" data-title="请关注微信订阅号进行投票" href="/images/weixin/8505.jpg">
                            <span class="glyphicon glyphicon-thumbs-up" style="padding-top: 3px;padding-bottom: 3px;"></span> <span class="note-count note-padding"><?=$item['num']?></span>
                        </a>
                    <?php else:?>
                        <div class="weicaht-note">
                            <?php $model = $voteusergood::findOne(['vote_id'=>$item['id'],'sayGood'=>$session->get('openId')]);?>
                            <span class="glyphicon glyphicon-thumbs-up <?php if(!empty($model)){echo 'vote-active';}?>" data-sex="<?=$item['sex']?>" onclick="vote_notes(<?=$item['id']?>,'<?=$session->get('openId')?>',this)"> </span>
                            <span class="note-count note-padding"><?=$item['num']?></span>
                        </div>
                    <?php endif;?>
                </li>
            <?php endforeach;?>
            <div style="clear: both;"></div>
        </ul>
    </div>

</div>
<div class="text-center"><?= LinkPager::widget(['pagination' => $pages,'firstPageLabel'=>"首页",'lastPageLabel'=>"末页",'prevPageLabel'=>'上页','nextPageLabel'=>'下页','maxButtonCount'=>0]); ?></div>

<div class="wrapper footer-list" style="max-width: 470px;">
    <a class="col-xs-4" href="http://mp.weixin.qq.com/s?__biz=MzI1MTEyMDI0Mw==&mid=2667464138&idx=1&sn=f74b546062babcb3fdd76738ec5c2304&chksm=f2fd3ad6c58ab3c028f7258e6342b0ed06e33e9a6a1e0aefbd4ba1348266d81938e75db2ccc5&scene=1&srcid=09109c1SKV9dl3B8K54Y2t7f#wechat_redirect">活动细则</a>
    <a class="col-xs-4" href="join?Id=<?=$session->get('Id')?>" style="box-shadow: 0 0 6px rgb(231,0,108);border-radius: 30px;font-size: 16px;font-weight: bold;background-color: #fff;color:rgb(231,0,108);">我要参赛</a>

    <a class="col-xs-4" href="center?Id=<?=$session->get('Id')?>">个人中心</a>
</div>
<!--</div>-->

<?php
$this->registerJs("
        $('.wall').jaliswall({ item: '.article' });
    ");
?>
<script>
    function vote_notes(id,openId,context){

        var cons = $(context);
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function stateChanged()
        {
            if (xhr.readyState==4 || xhr.readyState=="complete")
            {
                cons.siblings('.note-count').html(xhr.responseText);
                cons.addClass('vote-active');
            }
        };
        xhr.open('get','vote-click?id='+id+'&openId='+openId);
        xhr.send(null);
    }
</script>

