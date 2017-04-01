<?php
    use yii\helpers\Html;
    use frontend\assets\AppAsset;
    use yii\myhelper\Helper;
    use yii\web\View;
    use yii\helpers\Url;
    use \yii\myhelper\AccessToken;
    AppAsset::register($this);
    $this->registerCssFile('@web/js/lightbox/css/lightbox.css');
    $this->registerJsFile('@web/js/lightbox/js/lightbox.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);
    $this->registerCss('
        body,html{height: 100%;width: 100%;margin:0;padding:0;}
        body {color: #5a5a5a;height: 100%;width: 100%;}
        .marketing h2 {font-weight: normal;}
        .list-inline{margin-left: 0;}
        #top > .izl-rmenu > .btn{display: block;}
        #top > .izl-rmenu > .btn-top{display: none;}
        .marketing .col-lg-4 p {margin-right: 10px;margin-left: 10px;}
        .itemenu>ul>li{padding:2em 0 0 0;}
        .itemenu>ul>li>a{padding:0 0.5em 2.2em 0.5em;font-size:1.4em }
        .itemenu>ul>li>a>h5{text-align: center;font-family: "Glyphicons Halflings";font-size: 0.8em;}
        .loginover{position: relative;}
        .membershow li{list-style: none;padding: 5px 0;text-align: center;}
        .membershow li:hover{background-color: gainsboro;}
        .icon-bar{background-color: grey;}
        .dd{margin-top:10px;padding:0;}
        .cc>li>a{font-size: 1.2em;}
        .cc>li>a>h5{text-align: center;font-family: YGY20070701xinde52;}
        .icontop{margin-top: 30px;}
        .carousel-inner>.item>img{}
        .login13{width: 230px;}
        .navbar-nav > li > a:hover {color: rgba(239, 68, 80, 1);background:none;}
        .navbar{margin-bottom: 0;}
        .weixin-spacing{letter-spacing: 1em;}
        .table > thead > tr > th, .table > tbody > tr > th,
        .table > tfoot > tr > th, .table > thead > tr > td,
        .table > tbody > tr > td, .table > tfoot > tr > td {border-top: none; }
        .announcement{width: 100%;height: inherit;margin-bottom: 10px;background-color: #F7E5E5;padding:10px;}

        .announcement a{font-size: 14px;}
        .bar-active{color: rgba(239, 68, 80, 1);background:none;}
        .contact-phone{width: 100%;height: 50px;background-color:  white;overflow: hidden;text-align: center;line-height: 50px;margin-bottom:10px;margin-top: 10px;margin-left: 0px;position: relative;}
        .contact-phone li{width: 33%;height: 100%;padding: 0;float:left;margin-left:-1px;}
        .contact-phone li:hover{background-color:#F7E5E5;}
        .contact-phone li a{padding:15px 38px;text-decoration: none;}
        .contact-phone li a img{width:25px;}
        .self-footer{}
        .contact-phone li a:hover{color: white;}
        .contact-phone span{width:1px;height:20px;margin-top: 15px;margin-left:-1px;margin-right:-1px;border-left:1px solid #F7E5E5;float:left;}

        footer{margin-top: 40px;}
        .WB_follow_ex .follow_text{width:42px !important;}
        .WB_follow_ex .follow_btn_inner{width:70px;}
        .col-md-2 iframe{height:240px;}
        @media (max-width: 990px) {
            .login13{width: 200px;}
            .navbar-nav>li>a{padding:10px 5px;}
            .cc>li>a>h5{text-align: left;}
            .cc>li>a{font-size: 1em;}
            .cc>li{float: left;}
            .dd{margin-top: 10px;}
            .icontop{margin-top: 20px;}
        }
        @media (max-width:768px ) {
            .lb-details{text-align: center !important;}
            .lb-data .lb-caption{font-size:16px;}
            .lb-data .lb-details{width: 100%;}
            .lb-closeContainer{display:none;}
            .announcement a{font-size: 18px;}
            .membershow{left:70px;}
            .col-md-2{padding:0;}
            .navbar-nav>li>a{padding:10px 15px 10px 20px;}
            .weixin-spacing{letter-spacing: 2em;}
            .announcement .list-inline > li{margin-bottom: 5px;}
            .self-footer{background-color: white;margin-top: 10px;}
            .announcement{margin-top:15px;}
            .lb-nav{z-index:-1;}
            .self-footer .col-md-2{margin-top:10px;}
        }
        @media (min-width: 768px) {

            .carousel-caption p {margin-bottom: 20px;font-size: 21px;line-height: 1.4;}

        }
    ');
if(isset($_GET['top'])&&$_GET['top']=='bottom'){

    $this->registerCss('
        nav,footer{display:none;}
    ');
}
$rand_url = AccessToken::antiBlocking();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="<?=Yii::$app->setting->get('siteKeyword')?>">
    <meta name="Description" content="<?=Yii::$app->setting->get('siteDescription')?><?php echo 'd';?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="/js/chi/loaders.min.css"/>
    <link rel="stylesheet" href="/js/chi/loading.css"/>
    <link rel="shortcut icon" href="<?= Yii::getAlias('@web') ?>/favicon.ico">
    <?php $this->registerJsFile("/js/jquery-1.11.3.js",['position' => View::POS_HEAD]);?>
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "//hm.baidu.com/hm.js?23893b4e9b887b59f80ef6f2649ac0f1";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>

</head>
<body>
<div class="wrap">
    <nav class="navbar navbar-custom" role="navigation" style="background-color: white;margin-bottom: 10px;">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle navbar-default icontop" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a style="padding: 0;" href="<?=Url::toRoute(['/'])?>">
                    <img class="login13" src="<?= Yii::getAlias('@web')?>/images/logo1.png" alt="十三平台-中国领先的全球华人寻约交友平台" title="十三平台-中国领先的全球华人寻约交友平台">
                </a>
            </div>
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse dd">
                <ul class="nav navbar-nav cc">
                    <li><a href="<?=Url::toRoute(['/','url'=>$rand_url])?>">主页<h5>Home</h5></a></li>
                    <li><a href="<?=Url::toRoute(['/date-today','url_services'=>$rand_url])?>" <?php if(in_array(Yii::$app->request->getPathInfo(),['dating','datingt','date-today','date-past','hear-view','support-team','beautiful-people','firefighters'])||Yii::$app->request->getPathInfo()=='date-quality'||strpos(Yii::$app->request->getPathInfo(),'hear-view')!==false||strpos(Yii::$app->request->getPathInfo(),'date-view')!==false){echo 'class="bar-active"';}?>>最新觅约<h5>Dating</h5></a></li>
                    <li class="hidden-md hidden-lg"><a href="http://mp.weixin.qq.com/mp/homepage?__biz=MzAxMDIwMDIxMw==&hid=1&sn=a00a64d7d9db13c2540a42fe460d223d#wechat_redirect" <?php if(strpos(Yii::$app->request->getPathInfo(),'heart')!==false){echo 'class="bar-active"';}?>>心动周刊<h5>weekly</h5></a></li>
                    <li><a href="<?=Url::toRoute(['/services','url_services'=>$rand_url])?>" <?php if(Yii::$app->request->getPathInfo()=='services'){echo 'class="bar-active"';}?>>十三服务<h5>Service</h5></a></li>
                    <li><a href="<?=Url::toRoute(['/about','url_about'=>$rand_url])?>" <?php if(Yii::$app->request->getPathInfo()=='about'){echo 'class="bar-active"';}?>>关于我们<h5>About us</h5></a></li>
                    <li><a href="<?=Url::toRoute(['/contact','url_contact'=>$rand_url])?>" <?php if(Yii::$app->request->getPathInfo()=='contact'){echo 'class="bar-active"';}?>>联系我们<h5>Contact us</h5></a></li>

                        <?php if(Yii::$app->user->isGuest){?>
                            <li style="<?php if(strpos((string)Yii::$app->request->getPathInfo(),'forum/default') === 0){ echo 'display:none';}?>"><a href="/login">登录<h5>Login</h5></a></li>
                        <?php }else{?>
                            <li class="loginover"  style="<?php if(strpos((string)Yii::$app->request->getPathInfo(),'forum/default') === 0){ echo 'display:none';}?>">
                                <a href="/member/user"><?=Helper::truncate_utf8_string(Yii::$app->user->identity->username,4)?><h5>Yours</h5></a>
                            </li>
                        <?php }?>
                </ul>
            </div>
        </div>
    </nav>

 <!--   <div id="top" class=" visible-md visible-lg"></div>-->
<?php $this->beginBody() ?>
    <?= $content ?>
<?php $this->endBody() ?>
    <footer>
        <div class="container self-footer" style="padding: 0;">
            <div class="row" style="margin: 0;">
                <div class="col-md-4 text-center" style="padding-left: 0;padding-right: 0;">
                    <div class="center-block announcement">
                        <p style="width: 80%;" class="center-block">
                            <a class="btn btn-lg btn-primary btn-block" style="box-shadow: 0 1px 3px #7c7c7c;margin-bottom: 10px;color: #eee;" href="/forum/default" target="_blank">骗子&红包婊打击行动</a>
                            <a class="btn btn-lg btn-danger btn-block" style="box-shadow: 0 1px 3px #7c7c7c;margin-bottom: 10px;color: #eee" href="/test/check-service/index" target="_blank">十三客服微信号防伪查询</a>
                            <a class="btn btn-lg btn-default btn-block" style="margin-bottom: 10px;box-shadow: 0 1px 3px #7c7c7c;" href="https://itunes.apple.com/us/app/shi-san-jiao-you/id1070045426?l=zh&ls=1&mt=8"> ios版APP 已上线</a>
                        </p>
                    </div>
                </div>
                <!--微信公众号以及联系方式start-->
                <div class="col-md-4 text-center">
                    <div class="visible-sm visible-xs">
                        <ul class="list-inline contact-phone">
                            <li><a href="<?=Yii::getAlias('@web')?>/images/weixin/thirteenpingtai.jpg" data-lightbox="image" data-title="微信搜索公众号：心动三十一天" ><img alt="十三平台微信公众号" src="<?=Yii::getAlias('@web')?>/images/weichat-top.png"></a></li>
                            <span></span>
                            <li><a href="<?=Yii::getAlias('@web')?>/images/weixin/ed9e98fbedd51d1e26ed6a7b397c4b27.png" data-lightbox="image" data-title="IOS APP 下载" ><img alt="APP  下载" src="<?=Yii::getAlias('@web')?>/images/weixin/210712181883005415.png"></a></li>
                            <span></span>
                            <li><a href="http://wpa.qq.com/msgrd?v=3&uin=8495167&site=qq&menu=yes" target="_blank" ><img src="<?=Yii::getAlias('@web')?>/images/qq-top.png"></a></li>
                        </ul>
                    </div>
                    <div class="visible-lg visible-md" style="width: 49%;float: left;margin-right: 2%;">
                        <img class="img-responsive center-block" alt="IOS APP下载" src="<?=Yii::getAlias('@web')?>/images/weixin/ed9e98fbedd51d1e26ed6a7b397c4b27.png" width="100%">
                        <div class="weixin">IOS - APP - 下载</div>
                    </div>
                    <div class="visible-lg visible-md" style="width: 49%;float: left;">
                        <img class="img-responsive center-block" alt="十三平台微信公众号" src="<?=Yii::getAlias('@web')?>/images/weixin/thirteenpingtai.jpg" width="100%">
                        <div class="weixin-spacing">微信公众号</div>
                    </div>
                </div>
        <!--        <div class="col-md-2 text-center">
                    <div class="visible-sm visible-xs">
                        <ul class="list-inline contact-phone">
                            <li><a href="<?/*=Yii::getAlias('@web')*/?>/images/weixin/3.jpg" data-lightbox="image" data-title="微信搜索公众号：心动三十一天" ><img alt="十三平台微信公众号" src="<?/*=Yii::getAlias('@web')*/?>/images/weichat-top.png"></a></li>
                            <span></span>
                            <li><a href="http://wpa.qq.com/msgrd?v=3&uin=8495167&site=qq&menu=yes" target="_blank" ><img src="<?/*=Yii::getAlias('@web')*/?>/images/qq-top.png"></a></li>
                        </ul>
                    </div>
                    <div class="visible-lg visible-md">
                        <img class="img-responsive center-block" alt="十三平台微信公众号" src="<?/*=Yii::getAlias('@web')*/?>/images/weixin/thirteenpingtai.jpg" width="100%">
                        <div class="weixin-spacing">微信公众号</div>
                    </div>
                </div>-->
                <!--微信公众号以及联系方式end-->
                <div class="col-md-4">
                    <table class="table table-condensed table-hover" style="margin-bottom: 0;">
                        <tbody>
                        <tr><th>关于</th><th>服务</th><th>联系</th><th>帮助</th></tr>
                        <tr>
                            <td><?=Html::a('免责申明','/attention/disclaimer')?></td>
                            <td><?=Html::a('心动服务','/services')?></td>
                            <td><?=Html::a('联系我们','/contact')?></td>
                            <td>十三规则</td>
                        </tr>
                        <tr>
                            <td><?=Html::a('版权申明','/attention/copyright_notice')?></td>
                            <td><?=Html::a('商务合作','/attention/cooperation')?></td>
                            <td><?=Html::a('十三微信','/contact')?></td>
                            <td><?=Html::a('常见问题','/attention/problem')?></td>
                        </tr>
                        <tr>
                            <td><?=Html::a('关于隐私','/attention/privacy')?></td>
                            <td><?=Html::a('十三微博','http://weibo.com/13jiaoyoupt',['target'=>'_blank'])?></td>
                            <td>加入我们</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row text-center" style="padding:10px;margin: 0;display: none;">
            Copyright © 2015-2016 by 苏州三十一天网络科技有限公司. All Rights Reserved.备案号：苏ICP备15058554号-1<br>
        </div>
    </footer>
</body>
</html>
<?php $this->endPage() ?>
