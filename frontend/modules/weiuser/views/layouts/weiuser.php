<?php
    use yii\helpers\Html;
    use frontend\assets\WeiUserAsset;
    WeiUserAsset::register($this);
    $this->registerCss("
        body{background-color:#fbf9fe;font-family: 微软雅黑;}
        a:hover,a:visit{color:#000;}
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
</div>
</body>
</html>
<?php $this->endPage() ?>
