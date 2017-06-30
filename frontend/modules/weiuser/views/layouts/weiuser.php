<?php
    use yii\helpers\Html;
    use frontend\assets\WeiUserAsset;
    WeiUserAsset::register($this);
    $this->registerCss("
        p{margin-bottom:5px;}
        .container{padding:0;}
        .weui_tabbar{position: fixed;}
        body{background-color:#fbf9fe;font-family: 微软雅黑;}
        body,html,.container{height:100%;-webkit-tap-highlight-color:transparent}
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
    <div class="weui-tabbar" style="background-color: #fff;">
        <a href="javascript:;" class="weui-tabbar__item weui-bar__item_on">
                    <span style="display: inline-block;position: relative;">
                        <img src="/images/weiuser/icon_nav_button.png" alt="" class="weui-tabbar__icon">
                        <span class="weui-badge" style="position: absolute;top: -2px;right: -13px;">8</span>
                    </span>
            <p class="weui-tabbar__label">翻牌</p>
        </a>
        <a href="javascript:;" class="weui-tabbar__item">
            <img src="/images/weiuser/icon_nav_msg.png" alt="" class="weui-tabbar__icon">
            <p class="weui-tabbar__label">福救</p>
        </a>
        <a href="javascript:;" class="weui-tabbar__item">
                    <span style="display: inline-block;position: relative;">
                        <img src="/images/weiuser/icon_nav_article.png" alt="" class="weui-tabbar__icon">
                        <span class="weui-badge weui-badge_dot" style="position: absolute;top: 0;right: -6px;"></span>
                    </span>
            <p class="weui-tabbar__label">觅约</p>
        </a>
        <a href="javascript:;" class="weui-tabbar__item">
            <img src="/images/weiuser/icon_nav_cell.png" alt="" class="weui-tabbar__icon">
            <p class="weui-tabbar__label">我</p>
        </a>
    </div>
</div>
</body>
</html>
<?php $this->endPage() ?>
