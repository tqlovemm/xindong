<?php
use yii\widgets\LinkPager;
$session = Yii::$app->session;
if(!$session->isActive){
    $session->open();
}
$this->title = "男神评选";
$dinyue_userinfo= new \frontend\models\DinyueWeichatUserinfo();
$this->registerCss("
    .nav-tabs-top{width:100%;z-index:9;}
    .contact{display:none;}
    .wall-column{padding-bottom:0 !important;}
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
<div class="row form-group" style="margin: 10px 10px;">
    <form action="vote-man" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="number" name="entry_number" class="form-control" style="height: 20px;" placeholder="输入男生参赛者编号" required>
            <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat"><i class="glyphicon glyphicon-search"></i></button>
            </span>
        </div>
    </form>
</div>
<div class="nav-tabs-top">
    <a class="contact" href="/contact">
        <img class="img-responsive" src="<?=Yii::getAlias('@web')?>/images/vote/669179008377191553.png">
    </a>
    <ul id="myTab" class="nav nav-tabs nav-tabs-man" style="margin-bottom: 10px;background-color: #fff;">
        <li class="active">
            <a href="vote-man">男生 <img style="width: 25px;margin-top: -4px;" src="/images/vote/906898231657870808.png"></a>
        </li>
        <li style="border-right: 1px solid #eee;border-left: 1px solid #eee;">
            <a href="vote-woman">女生 <img style="width: 25px;margin-top: -6px;" src="/images/vote/23587436294114443.png"></a>
        </li>
        <li>
            <a href="vote-top" style="position: relative;">排行榜<img style="width: 26px;position: absolute;top:-6px;right: 3px;" src="/images/vote/huangguan.png"></a>
        </li>
    </ul>
</div>
    <div id="myTabContent" class="tab-content" style="padding-bottom: 50px;min-height: 300px;">
        <div class="tab-pane fade in active" id="man">
            <ul class="wall">
                <?php
                shuffle($model);
                foreach ($model as $key=>$item):?>
                    <li class="article" style="">
                        <h5 style="margin-top: 0;color:gray;">参赛编号：<?=$item['id']?>号</h5>
                        <a href="sign-detail?id=<?=$item['id']?>">
                            <?php foreach ($item['voteSignImgs'] as $k=>$list):
                                if($k==1) break; ?>
                                <img src="<?=$list['img']?>"/>
                            <?php endforeach;?>
                        </a>

                        <div class="note-count note-padding"> <?=$item['vote_count']?></div>
                        <?php if(empty($dinyue_userinfo::findOne(['unionid'=>$session->get('vote_01_openid')]))):?>
                            <a class="weicaht-note" style="display: block;text-align: center;background-color:#23212E" data-lightbox="d" data-title="请关注微信订阅号进行投票" href="/images/weixin/149129585220305657.jpg">
                               <span class="glyphicon glyphicon-heart"></span> <span style="font-size: 16px;">投票</span>
                            </a>
                        <?php else:?>
                            <div class="weicaht-note" style="display: block;background-color:#23212E ;text-align: center;" data-sex="<?=$item['sex']?>" onclick="vote_notes(<?=$item['id']?>,this)">
                                <span class="glyphicon glyphicon-heart"></span> <span style="font-size: 16px;">投票</span>
                            </div>
                        <?php endif;?>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="text-center"><?= LinkPager::widget(['pagination' => $pages,'firstPageLabel'=>false,'lastPageLabel'=>false]); ?></div>

    </div>



<?php
    $this->registerJs("
        $('.wall').jaliswall({ item: '.article' });
    ");
?>


