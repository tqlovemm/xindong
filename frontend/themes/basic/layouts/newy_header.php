<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

$session = Yii::$app->session;
if(!$session->isActive){
    $session->open();
}
AppAsset::register($this);
$this->registerCss('
        .col-md-9{background-color: #FFF;border: 1px solid gainsboro;border-radius: 3px;}
        .navbar-default .navbar-brand,.navbar-default .navbar-nav > li > a,
        .navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus{color:#fff !important;}
        .navbar-default .navbar-toggle .icon-bar{background-color:#fff;}
        .navbar-default .navbar-toggle:hover{background-color:transparent;}

        .member-center header{width:100%;height:44px;background: #23212E;position: relative;z-index: 10;}
        .member-center header a{color:white;position: absolute;}
        .member-center header h2{color: #fff;font-size: 16px;font-weight: normal;height:44px;text-align: center;line-height:44px;font-weight: bold;margin-top: 0;}
        .member-center header span{display: block;height: 35px;text-indent: 17px;width: 50px;color: #FFF;font-size: 14px;padding-top: 8px;margin-left: -10px;}
        .member-center header span img{width: 25px;}
');
if(isset($_GET['top'])&&$_GET['top']=='bottom'){

    $this->registerCss('
        nav,footer{display:none;}
    ');
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="十三平台,十三交友平台,心动三十一天,约啪交友,走心走肾,私密社交,泡妞搭讪,网上交友,征婚交友网,交友中心">
    <meta name="Description" content="十三交友平台是中国最大的在线觅约交友圣地，旗下多个娱乐交友子平台，通过互联网、线上交友和线下聚会为中国大陆、港澳台及海内外各界优秀单身人士提供精准高效的约会服务！已有成千上万会员在这里成功觅约！">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="<?= Yii::getAlias('@web') ?>/favicon.ico">
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
<?php $this->beginBody() ?>
<div class="wrap" style="height: 100%;">
    <div class="container-fluid" style="height: 100%;position: relative;">
        <div class="center-block" style="max-width: 470px;">
            <div style="background-color: #31313e;height: 40px;position: relative;">
                <a href="man">
                    <span style="font-size: 14px;position: absolute;top: 10px;left: 20px;color:#B58900;">首页</span>
                </a>
                <h2 style="color: #B58900;text-align: center;line-height: 40px;margin-top: 0;font-size: 18px;">
                    新春ID照
                </h2>
                <a href="center-info?id=<?=$session->get('id')?> " style="position: absolute;right:20px;top:10px;color:#B58900;">统计</a>
            </div>
            <img class="img-responsive" src="/images/vote/681880538783171288.jpg">
            <a href="http://mp.weixin.qq.com/s/IhEg7rG-ls01lFpBAGri6w">
            <img class="img-responsive" src="/images/vote/23428177598021344.jpg">
            </a>
            <div class="row form-group" style="margin: 10px 10px;">
                <form action="find-one" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="number" name="entry_number" class="form-control" style="height: 34px;padding:0" placeholder="输入参赛者编号" required>
            <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat"><i class="glyphicon glyphicon-search"></i></button>
            </span>
                    </div>
                </form>
            </div>


            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>

        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>

<?php $this->endPage() ?>
