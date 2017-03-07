<?php
use \yii\myhelper\AccessToken;
$this->registerCss('

    .gotop {background-image: url(../images/iconfont-fanhuidingbu.png);background-repeat: no-repeat;background-position: center center;background-size: 40px;height: 40px;width: 40px;position: fixed;right: 10px;bottom: 50px;z-index: 9999;cursor: pointer;}
    .accc{margin-bottom: 0;margin-left: 0;padding:10px;background-color: white;}
    .accc>li>a{font-size: 14px;width: 100%;padding:2px;}
    .accc>li{padding:0;width: 23%;}
    .left-bg{width: 150px;height: 100%;background-color: #fff;margin-bottom: 10px;padding:5px 5px;border:2px solid rgba(239, 68, 80, 1);}
    .suo-xia{padding:0 5px !important;}
    .addbg>a,.left-bg:hover a{color: #fff;}
    .left-bg a{font-size: 1.5em;padding-left:10px;width: 100%;height: 100%;}

    .share{padding:10px 35px;background-color: white;margin: 10px 0 10px 0;display: none;}
    .btn-self{color:white;background-color: rgba(239, 68, 80, 1);}
    .bar-ul{background-color: white;box-shadow: 0 0 5px #dbdbdb;text-align: center;padding-top: 20px;padding-bottom: 20px;}
    .pagination{margin:10px 0 !important;}
    .bar-ul a{border:none;margin-bottom: 20px;letter-spacing: 5px;width: 80%;font-size: 16px;}
    .bar-ul>.addbg{ background-color: rgba(239, 68, 80, 1);color:white;}
    .addbg:hover{ background-color:rgba(239, 68, 80, 1) !important;color:white !important;}
    .fixeds{display:none;position:fixed;top:0;left:0;z-index:9;border-bottom:1px solid #E6E4E4;width: 100%; margin-bottom: 10px;}
');

?>
<div class="hidden-xs visible-md visible-lg">
    <div class="bar-ul">
        <a href="/date-today?url=<?=AccessToken::antiBlocking()?>" class="list-group-item center-block
        <?php if(Yii::$app->getRequest()->get('type')=='datingnews'||Yii::$app->getRequest()->get('type')=='dating'||Yii::$app->request->getPathInfo()=='date-past'||Yii::$app->request->getPathInfo()=='date-today'||Yii::$app->request->getPathInfo()=='date-view'||strpos(Yii::$app->request->getPathInfo(),'date-view')!==false){echo 'addbg';}?>">
           觅约信息
        </a>
        <a href="/firefighters?url=<?=AccessToken::antiBlocking()?>" class="list-group-item center-block <?php if(in_array(Yii::$app->request->getPathInfo(),['beautiful-people','firefighters'])){echo 'addbg';}?>">
            十三救我
        </a>
        <a href="/hear-view?url=<?=AccessToken::antiBlocking()?>" class="list-group-item center-block <?php if(in_array(Yii::$app->request->getPathInfo(),['exciting'])||strpos(Yii::$app->request->getPathInfo(),'hear-view')!==false){echo 'addbg';}?>">
           心动故事
        </a>
        <a href="/date-quality?url=<?=AccessToken::antiBlocking()?>" class="list-group-item center-block <?php if(Yii::$app->request->getPathInfo()=='date-quality'){echo 'addbg';}?>">
            优质后援
        </a>
    </div>
</div>

<div class="visible-xs visible-sm">
    <ul class='list-group list-inline accc'>
        <li><a href="/date-today?url=<?=AccessToken::antiBlocking()?>" class="btn btn-sm <?php if(Yii::$app->getRequest()->get('type')=='datingnews'||Yii::$app->getRequest()->get('type')=='dating'||Yii::$app->request->getPathInfo()=='date-past'||Yii::$app->request->getPathInfo()=='date-today'||Yii::$app->request->getPathInfo()=='date-view'||strpos(Yii::$app->request->getPathInfo(),'date-view')!==false){echo 'btn-self';}?>">觅约信息</a></li>
        <li><a href="/firefighters?url=<?=AccessToken::antiBlocking()?>" class="btn btn-sm <?php if(in_array(Yii::$app->request->getPathInfo(),['beautiful-people','datingt','firefighters'])){echo ' btn-self';}?>">十三救我</a></li>

        <li><a href="/hear-view?url=<?=AccessToken::antiBlocking()?>" class="btn btn-sm <?php if(in_array(Yii::$app->request->getPathInfo(),['exciting'])||strpos(Yii::$app->request->getPathInfo(),'hear-view')!==false){echo ' btn-self';}?>">心动故事</a></li>
        <li><a href="/date-quality?url=<?=AccessToken::antiBlocking()?>" class="btn btn-sm <?php if(Yii::$app->request->getPathInfo()=='date-quality'){echo ' btn-self';}?>">优质后援</a></li>

    </ul>
</div>
<div class="fixeds hidden-md hidden-lg">
    <ul class='list-group list-inline accc'>
        <li><a href="/date-today?url=<?=AccessToken::antiBlocking()?>" class="btn btn-sm <?php if(Yii::$app->getRequest()->get('type')=='datingnews'||Yii::$app->getRequest()->get('type')=='dating'||Yii::$app->request->getPathInfo()=='date-past'||Yii::$app->request->getPathInfo()=='date-today'||Yii::$app->request->getPathInfo()=='date-view'||strpos(Yii::$app->request->getPathInfo(),'date-view')!==false){echo 'btn-self';}?>">觅约信息</a></li>
        <li><a href="/firefighters?url=<?=AccessToken::antiBlocking()?>" class="btn btn-sm <?php if(in_array(Yii::$app->request->getPathInfo(),['beautiful-people','firefighters'])){echo ' btn-self';}?>">十三救我</a></li>
        <li><a href="/hear-view?url=<?=AccessToken::antiBlocking()?>" class="btn btn-sm <?php if(strpos(Yii::$app->request->getPathInfo(),'hear-view')!==false){echo ' btn-self';}?>">心动故事</a></li>
        <li><a href="/date-quality?url=<?=AccessToken::antiBlocking()?>" class="btn btn-sm <?php if(Yii::$app->request->getPathInfo()=='date-quality'){echo ' btn-self';}?>">优质后援</a></li>
    </ul>
</div>
<div class="gotop backtop hidden-lg hidden-md" style="display: none;"></div>

<script type="text/javascript">
    //返回顶部
    $(document).ready(function(){

        $(window).scroll(function () {
            var scrollHeight = $(document).height();
            var scrollTop = $(window).scrollTop();
            var $windowHeight = $(window).innerHeight();
            scrollTop > 75 ? $(".gotop").fadeIn(200).css("display","block") : $(".gotop").fadeOut(200).css({"background-image":"url(<?=Yii::getAlias("@web")?>/images/iconfont-fanhuidingbu.png)"});
        });
        $('.backtop').click(function (e) {
            $(".gotop").css({"background-image":"url(<?=Yii::getAlias("@web")?>/images/iconfont-fanhuidingbu_up.png)"});
            e.preventDefault();
            $('html,body').animate({ scrollTop:0});
        });
    });
</script>
<script type="text/javascript">

    $(document).ready(function(){
        $(window).scroll(function () {
            var scrollHeight = $(document).height();
            var scrollTop = $(window).scrollTop();
            var $windowHeight = $(window).innerHeight();
            scrollTop > 84 ? $(".fixeds").fadeIn(500): $(".fixeds").fadeOut(100);
        });

    });
</script>
