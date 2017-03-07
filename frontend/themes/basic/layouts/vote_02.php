<?php $this->beginContent('@app/themes/basic/layouts/main.php'); ?>
<?php
$session = Yii::$app->session;
if(!$session->isActive){
    $session->open();
}
$id = \frontend\modules\weixin\models\VoteSignInfo::findOne(['openid'=>$session->get('vote_01_openid'),'status'=>[1,2]])['id'];
$this->registerCssFile("@web/css/note/base.css");
$this->registerCssFile("@web/css/note/style.css");

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
     
    .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus{color: #F1BE2A;cursor: default;background-color: transparent;border: 1px solid #ddd;border:none;}
    .nav-tabs-woman > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus{color: #E8437B;}
    .nav-tabs-man > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus{color: #000;}
    .nav-tabs > li > a {margin-right: 0;line-height: 1.42857143;border: 1px solid transparent;border-radius: 4px 4px 0 0;font-size:18px;color:#bbb;}

    .nav-tabs > li{width:33.3%;text-align:center;}
    .footer-list{position: fixed;z-index: 999;bottom:0;width: 100%;background-color: #22222E;text-align: center;padding:6px 0;}
    .footer-list a{padding:6px 0;color:#fff;}
    .wall-column{padding-bottom:40px;}
    .note-count{padding:0 8px;color:gray;text-align:center;}
    .note-padding{padding:8px}
    .note-count:before{content:'总票数：';}
    .weicaht-note{ padding: 4px 10px;width:100%; border-radius: 4px; font-size: 14px; z-index: 100; background-color: #F74D8B; border: none; color: #fff !important; box-shadow: 0 0 7px #d7d7d7;}

");
?>
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <div style="background-color: #31313e;height: 40px;">
        <a href="vote-woman">
            <span style="font-size: 14px;position: absolute;top: 10px;left: 10px;color:#fff;">首页</span>
        </a>
        <h2 style="color: #fff;text-align: center;line-height: 40px;margin-top: 0;font-size: 18px;">
            <?=$this->title?>
        </h2>
        <a href="personal-center" style="position: absolute;right:10px;top:10px;color:#fff;">统计</a>
    </div>
    <div class="wapper adv_1">
        <a href="vote-woman">
            <img class="img-responsive" src="<?=Yii::getAlias('@web')?>/images/vote/48627877580200137.jpg">
        </a>
    </div>
    <div class="wapper text-center">
        <img class="img-responsive adv_2" src="<?=Yii::getAlias('@web')?>/images/vote/709457302195701556.png">
        <a href="/contact">
            <img class="img-responsive" src="<?=Yii::getAlias('@web')?>/images/vote/669179008377191553.png">
        </a>
    </div>
    <?=$content?>
    <div class="wrapper footer-list">
        <a class="col-xs-4" href="http://mp.weixin.qq.com/s?__biz=MzI1MTEyMDI0Mw==&mid=2667464138&idx=1&sn=f74b546062babcb3fdd76738ec5c2304&chksm=f2fd3ad6c58ab3c028f7258e6342b0ed06e33e9a6a1e0aefbd4ba1348266d81938e75db2ccc5&scene=1&srcid=09109c1SKV9dl3B8K54Y2t7f#wechat_redirect">活动细则</a>
        <a class="col-xs-4" href="vote-sign" style="box-shadow: 0 0 6px rgb(231,0,108);border-radius: 30px;font-size: 16px;font-weight: bold;background-color: #fff;color:rgb(231,0,108);">我要参赛</a>
        <?php if(empty($id)):?>
            <a class="col-xs-4" href="vote-sign">个人中心</a>
        <?php else:?>
            <a class="col-xs-4" href="sign-detail?id=<?=$id?>">个人中心</a>
        <?php endif;?>
    </div>
    <script>
        function vote_notes(id,context){

            var cons = $(context);
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function stateChanged()
            {
                if (xhr.readyState==4 || xhr.readyState=="complete")
                {
                    cons.siblings('.note-count').html(xhr.responseText);
                }
            };
            xhr.open('get','vote-click?id='+id+'&type='+cons.attr('data-sex'));
            xhr.send(null);
        }
    </script>
<?php $this->endContent(); ?>
