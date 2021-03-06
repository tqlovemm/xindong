<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

if (!isset($this->title)) {
    $this->title = Yii::$app->setting->get('siteTitle');
}
if (Yii::$app->user->isGuest) {
    $this->beginContent(__DIR__.'/main.php');
} else {
	$this->registerCssFile('@web/css/site.css');
    $this->beginContent('@app/modules/user/views/layouts/user.php');
}
$this->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->setting->get('siteKeyword')]);
$this->registerMetaTag(['name' => 'description', 'content' => Yii::$app->setting->get('siteDescription')]);
?>

<div class="page-header">
  <h1><?= $this->params['title'] ?> <small><?= Yii::$app->setting->get('siteTitle') ?></small></h1>
</div>
<?php
NavBar::begin([
    'options' => [
        'class' => 'navbar-default',
    ],
]);
$menuItems = [
    ['label' => '<i class="glyphicon glyphicon-globe"></i> ' . Yii::t('app', 'Home'), 'url' => ['/explore/index']],
    ['label' => '<i class="glyphicon glyphicon-picture"></i> ' . Yii::t('app', 'Photos'), 'url' => ['/explore/photos']],
    ['label' => '<i class="glyphicon glyphicon-list-alt"></i> ' . Yii::t('app', 'Posts'), 'url' => ['/explore/posts']],
    ['label' => '<i class="glyphicon glyphicon-comment"></i> ' . Yii::t('app', 'Forums'), 'url' => ['/forum/board/view?sort=-t.created_at']],
];
echo Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
    'items' => $menuItems,
]);
NavBar::end();
?>
<?= Breadcrumbs::widget([
	'homeLink' => ['label' => Yii::t('app', 'Explore'), 'url' => ['/explore/index1']],
	'links' => isset($this->params['breadcrumb']) ? $this->params['breadcrumb'] : [],
]) ?>
<div class="content">
    <?= $content; ?>
</div>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::a(Yii::$app->setting->get('siteName'), ['/site/index']) ?> <?= date('Y') ?>
            <?= Html::a (' ���ļ��� ', '?lang=zh-CN') . '| ' .
            Html::a (' English ', '?lang=en') ;
            ?>
        </p>
        <p class="pull-right">ʮ������ƽ̨</p>
    </div>
</footer>
<?php $this->endContent(); ?>
