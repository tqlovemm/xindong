<?php

$this->title = "十三平台 #炫腹季#";
$this->registerCssFile("@web/css/note/base.css");
$this->registerCssFile("@web/css/note/style.css");

$session = Yii::$app->session;
if($session->isActive)
    $session->open();

$dinyue_userinfo = new \frontend\models\DinyueWeichatUserinfo();
$this->registerCssFile('@web/js/lightbox/css/lightbox.css');
$this->registerJsFile('@web/js/lightbox/js/lightbox.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);
$this->registerCss("

    .container-fluid{padding:0;}
    .lightbox .lb-image{z-index:9999;width:250px !important;height:250px !important;}
    .lb-data .lb-number{display:none !important;}
    .lb-data .lb-caption{font-size:16px;}
    .lb-data .lb-close{display:none;}
    .lb-dataContainer{text-align:center;}
    .lb-data .lb-details{margin-top:5px;text-align:right;}
    .lb-nav{z-index:-1;}
    
    .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focuss{
        color: #fff;
        cursor: default;
        background-color: red !important;
        border: 1px solid #ddd;
        border-bottom-color: transparent;
    }  
    .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus{
     color: #fff;
    cursor: default;
    background-color: rgb(231,0,108);
    border: 1px solid #ddd;
    border-bottom-color: transparent;
    
    }
    .nav-tabs > li > a {

    margin-right: 2px;
    line-height: 1.42857143;
    border: 1px solid transparent;
    border-radius: 4px 4px 0 0;
}
 .nav-tabs > li{width:33.3%;text-align:center;}

");
?>

<div style="background-color: rgb(231,0,108);width: 100%;height: 4em;">
    <h2 style="color: white;text-align: center;line-height: 56px;margin-top: 0;"><?=$this->title?></h2>
</div>
<div class="wapper">
    <li class="article" style="margin-bottom: 10px;">
        <img src="<?=Yii::getAlias('@web')?>/images/weixin/345164949108829645.jpg">
    </li>
</div>
<div class="row" style="margin: 0;padding:10px;background-color: #fff;color:gray;">十三交友平台，<span style="color: rgb(231,0,108);">10000+</span>优质男女在线互动<br>好玩有趣 轻松交友~~更有多种微信玩耍群<br>女生加微信：<span style="color: rgb(231,0,108);">bb-shisan</span> <br>男生加微信：<span style="color: rgb(231,0,108);">shisan-3</span>  </div>
<div class="wrapper" style="margin-top: 10px;">
<div class="row form-group" style="margin: 0 0 10px 0;">

        <form action="/weichat-note/note-index" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="type" class="form-control" style="height: 20px;" placeholder="输入参赛者编号可查找" required>
                <span class="input-group-btn">
                    <button type="submit" id="search-btn" class="btn btn-flat"><i class="glyphicon glyphicon-search"></i></button>
                </span>
            </div>
        </form>

</div>

    <ul id="myTab" class="nav nav-tabs" style="margin-bottom: 10px;">
        <li class="active">
            <a href="#index" data-toggle="tab">
                全部
            </a>
        </li>
        <li>
            <a href="#top5" data-toggle="tab">Top6</a>
        </li>
        <li>
            <a id="vote_click" href="#vote" data-toggle="tab">投手榜</a>
        </li>
    </ul>
    <div id="myTabContent" class="tab-content" style="min-height: 500px;">
        <div class="tab-pane fade in active" id="index">

            <ul class="wall">
                <?php foreach ($photo as $key=>$item):?>
                    <li class="article" style="">
                        <h5 style="margin-top: 0;color:gray;"><?=$item['id']?>号</h5>
                        <a href="entrants-detail?id=<?=$item['id']?>">
                            <img src="<?=$item['path']?>"/>
                        </a>

                        <h6>编号：<?=$item['name']?></h6>
                        <div class="col-xs-6 note-count" style="padding:0;color:rgb(231,0,108);">
                            <?=$item['note_count']?>票
                        </div>
                        <?php if(empty($dinyue_userinfo::findOne(['unionid'=>$session->get('13_openid')]))):?>
                            <a class="col-xs-6" style="padding:0;text-align: right;" data-lightbox="d" data-title="请关注微信订阅号进行投票" href="/images/weixin/149129585220305657.jpg">
                                <span class="weicaht-note">投票</span>
                            </a>
                        <?php else:?>
                            <div class="col-xs-6" style="padding:0;text-align: right;" onclick="notes(<?=$item['id']?>,this)">
                                <span class="weicaht-note">投票</span>
                            </div>
                        <?php endif;?>

                    </li>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="tab-pane fade" id="top5">

            <ul>
            <?php foreach ($top as $key=>$item):?>
                <li class="article" style="">
                    <h4 class="row">
                        <div class="col-xs-4">
                            第<?=$key+1?>名
                        </div>
                        <div class="col-xs-6">
                            <h5 style="margin-top: 5px;"><?=$item['id']?>号</h5>
                        </div>
                    </h4>
                    <a href="entrants-detail?id=<?=$item['id']?>" style="position: relative;">
                        <img src="<?=$item['path']?>"/>
                    </a>
                    <h5 class="row">
                        <div class="col-xs-6">
                            编号：<?=$item['name']?>
                        </div>
                    </h5>
                    <?php if($item['thumb']!='no'):?>
                    <h5><?=$item['thumb']?></h5>
                    <?php endif;?>
                    <div class="col-xs-6 note-count" style="padding:0;color:rgb(231,0,108);">
                        总票数：<?=$item['note_count']?>
                    </div>
                    <?php if(empty($dinyue_userinfo::findOne(['unionid'=>$session->get('13_openid')]))):?>
                        <a class="col-xs-6" style="padding:0;text-align: right;" data-lightbox="d" data-title="请关注微信订阅号进行投票" href="/images/weixin/149129585220305657.jpg">
                            <span class="weicaht-note">给TA投票</span>
                        </a>
                    <?php else:?>
                        <div class="col-xs-6" style="padding:0;text-align: right;" onclick="notes(<?=$item['id']?>,this)">
                            <span class="weicaht-note">给TA投票</span>
                        </div>
                    <?php endif;?>

                </li>
            <?php endforeach;?>
            </ul>
        </div>
        <div class="tab-pane fade" id="vote">
            <ul id="vote_content">
                <?php foreach ($vote as $key=>$item):?>
                    <li class="article" style="margin-bottom: 0;border-bottom: 1px solid #ececec;">
                        <div class="col-xs-3" style="padding:0;">
                            <img style="border-radius: 5px;width: 60px;" class="img-responsive" src="<?=$item['headimgurl']?>">
                        </div>
                        <div class="col-xs-8" style="padding: 0;">
                            <h4 style="margin-left: 0;">
                                <?=$item['nickname']?>
                            </h4>
                            <h5 style="margin-bottom: 0;">
                                已投<?=$item['total']?>票
                            </h5>
                        </div>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>
<?php
    $this->registerJs("

        $('.wall').jaliswall({ item: '.article' });
       
        function ale() {
            //弹出一个对话框
            alert('投票成功！');
        }
 
    ");

?>
<script>

    function notes(id,context){

        var cons = $(context);
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function stateChanged()
        {
            if (xhr.readyState==4 || xhr.readyState=="complete")
            {
                cons.siblings('.note-count').html(xhr.responseText);

            }
        };
        xhr.open('get','/weichat-note/note-click?id='+id);
        xhr.send(null);
    }
</script>

