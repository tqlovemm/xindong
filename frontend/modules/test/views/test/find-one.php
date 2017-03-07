<?php
$session = Yii::$app->session;
if(!$session->isActive){
    $session->open();
}
$this->title = "最美ID照";
$voteusergood = new \frontend\modules\test\models\VoteUserGood();
$this->registerCssFile("@web/css/note/base.css");
$this->registerCssFile("@web/css/note/style.css");
$this->registerCss("
    .nav-tabs-top{width:100%;z-index:9;}
    .contact{display:none;}
    .wall-column{margin-bottom:80px;}
    .wall{padding:0px;list-style-type:none;margin-top: 8px;}
    .container-fluid{padding:0px;}
    .footer-list{position: fixed;z-index: 999;bottom:0;width: 100%;background-color: #22222E;text-align: center;padding:6px 0;}
    .footer-list a{padding:6px 0;color:#fff;}
    .vote-active{color:#F74D8B;font-size:15px}
");

?>
<div class="nav-tabs-top" >
    <ul id="myTab" class="nav nav-tabs nav-tabs-man text-center" style="margin-bottom: 0px;background-color: #fff;">
        <li  style="width: 33%">
            <a href="man">男生 <img style="width: 25px;margin-top: -4px;" src="/images/vote/906898231657870808.png"></a>
        </li>
        <li style="border-right: 1px solid #eee;border-left: 1px solid #eee; width: 33%">
            <a href="women">女生 <img style="width: 25px;margin-top: -6px;" src="/images/vote/23587436294114443.png"></a>
        </li>
        <li style="border-right: 1px solid #eee;border-left: 1px solid #eee; width: 33%">
            <a href="top" style="position: relative;">排行榜<img style="width: 26px;position: absolute;top:-6px;right: 3px;" src="/images/vote/huangguan.png"></a>
        </li>
    </ul>
</div>
<div id="myTabContent" class="tab-content" style="min-height: 350px;">
    <div class="tab-pane fade in active" id="man">
        <ul class="wall" >
                <?php if(!empty($model)):?>
                <li class="article" style="text-align: center;float: left;padding-left: 8px;padding-right: 6px;margin-bottom: 10px" >
                    <h5 style="margin-top: 0;color:gray;text-align: left;padding-top: 5px;;">参赛编号：<?=$model['id']?>号</h5>
                    <a href="center?Id=<?=$model['id']?>" >
                        <?php
                            foreach ($model['imgs'] as $k=>$list):
                                if($k==1) break; ?>
                            <img src="<?=$list['thumb']?>" style="max-width: 98%"/>
                        <?php
                            endforeach;
                        ?>
                    </a>

                    <?php if($subscribe != 1):?>
                        <a class="weicaht-note" style="display:block;padding:0;color: #C1C1C1" data-lightbox="d" data-title="请关注微信订阅号进行投票" href="/images/weixin/8505.jpg">
                            <span class="glyphicon glyphicon-thumbs-up" style="padding-top: 3px;padding-bottom: 3px;"></span> <span class="note-count note-padding"><?=$model['num']?></span>
                        </a>
                    <?php else:?>
                        <div class="row" style="padding-left: 15px;padding-top: 3px;color:#C1C1C1;">
                            <?php $model2 = $voteusergood::findOne(['vote_id'=>$model['id'],'sayGood'=>$session->get('openId')]);?>
                            <span class="glyphicon glyphicon-thumbs-up <?php if(!empty($model2)){echo 'vote-active';}?>" data-sex="<?=$model['sex']?>" onclick="vote_notes(<?=$model['id']?>,'<?=$session->get('openId')?>',this)"> </span>
                            <span class="note-count note-padding"><?=$model['num']?></span>
                        </div>
                    <?php endif;?>
                </li>
            <?php
                endif;
            ?>
            <div style="clear: both;"></div>
        </ul>
    </div>

</div>

<div class="wrapper footer-list" style="max-width: 470px;margin-top:50px;">
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


