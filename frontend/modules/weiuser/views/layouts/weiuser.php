<?php
    use yii\helpers\Html;
    use frontend\assets\WeiUserAsset;
    WeiUserAsset::register($this);
    $this->registerCss("
        p{margin-bottom:5px;}
        .container{padding:0;}
        .weui_tabbar{position: fixed;}
        body{background-color:#fbf9fe;font-family: 微软雅黑;}
        body,html,.container,.weui_panel{height:100%;-webkit-tap-highlight-color:transparent}
    ");
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <meta name="keywords" content="<?=Yii::$app->setting->get('siteKeyword')?>">
    <meta name="Description" content="<?=Yii::$app->setting->get('siteDescription')?>">
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
</head>
<body ontouchstart>
<div class="container" id="container">
<?php $this->beginBody() ?>
    <?= $content ?>
<?php $this->endBody() ?>

    <div class="weui_tabbar" style="background-color: #fff;">
        <a href="javascript:;" class="weui_tabbar_item weui_bar_item_on">
            <div class="weui_tabbar_icon">
                <img src="/images/weiuser/icon_nav_button.png" alt="">
            </div>
            <p class="weui_tabbar_label">翻牌</p>
        </a>
        <a href="javascript:;" class="weui_tabbar_item">
            <div class="weui_tabbar_icon">
                <img src="/images/weiuser/icon_nav_msg.png" alt="">
            </div>
            <p class="weui_tabbar_label">福救</p>
        </a>
        <a href="javascript:;" class="weui_tabbar_item">
            <div class="weui_tabbar_icon">
                <img src="/images/weiuser/icon_nav_article.png" alt="">
            </div>
            <p class="weui_tabbar_label">觅约</p>
        </a>
        <a href="javascript:;" class="weui_tabbar_item">
            <div class="weui_tabbar_icon">
                <img src="/images/weiuser/icon_nav_cell.png" alt="">
            </div>
            <p class="weui_tabbar_label">我</p>
        </a>
    </div>

</div>
</body>
</html>
<?php $this->endPage() ?>
