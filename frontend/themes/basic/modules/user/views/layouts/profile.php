<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\themes\basic\modules\user\ProfileAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

ProfileAsset::register($this);
$user = Yii::$app->user->identity;

//关注按钮
$done = Yii::$app->db
    ->createCommand("SELECT 1 FROM {{%user_follow}} WHERE user_id=:user_id AND people_id=:id LIMIT 1")
    ->bindValues([':user_id' => Yii::$app->user->id, ':id' => $this->params['user']['id']])->queryScalar();
if ($done) {
    $followBtn = '<span class="glyphicon glyphicon glyphicon-eye-close"></span> ' . Yii::t('app', 'Unfollow');
} else {
    $followBtn = '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('app', 'Follow');
}
    $this->registerCss('

    .container,.wrap{padding-top:0 !important;}

    .bg-white{background-color:white;}
    .main-hen1{background:none;border: none;margin-left: 38%;}
    .main-hen2{background:none;border: none;margin-left: 10%;}
    @media (min-width: 1200px){
        .container {
            width: 1170px !important;
        }
    }
    @media (max-width: 768px){

         .main-hen1,.main-hen2{margin: auto;float:none;}
    }

');
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
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
    <div class="wrap">
        <div class="btn-panel">
            <?= Html::a(Yii::$app->setting->get('siteName'), ['/forum/forum/views'], ['class' => 'btn btn-warning']) ?>
        </div>
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <div class="row">
                <div style="width: 100%;height: 250px;background:url('<?=Yii::getAlias('@web')?>/images/home/home_top.gif') 100% #e0ddd6; ">
                    <div class="text-center" style="padding:10px 20px;">
                        <img style="width: 80px;" class="img-circle img-responsive center-block" src="<?= Yii::getAlias('@avatar') . $this->params['user']['avatar'] ?>">
                        <h2 class="profile-name">

                            <?php if(!empty($this->params['user']['nickname'])){echo Html::a(Html::encode($this->params['user']['nickname']), ['/user/view', 'id' => Html::encode($this->params['user']['username'])]);}else{echo Html::a(Html::encode($this->params['user']['username']), ['/user/view', 'id' => Html::encode($this->params['user']['username'])]);} ?>

                        </h2>
                        <?php if (!empty($this->params['profile']['description'])): ?>
                            <p class="mb30"><?= Html::encode($this->params['profile']['description']) ?></p>
                        <?php endif ?>
                        <div class="mb20"></div>
                        <a class="btn btn-success follow btn-sm" href="<?= Url::toRoute(['/user/user/follow', 'id' => $this->params['user']['id']]) ?>"><?= $followBtn ?></a>
                    </div>
                </div>
            </div>
            <div class="row text-center bg-white">
                <a class="list-group-item pull-left main-hen1" href="">我的论坛</a>
                <a class="list-group-item pull-left main-hen2">我的相册</a>
            </div>
            <br>



      <!--      <div class="row">
                <div class="col-sm-3">

                    <img style="min-width: 100%" src="<?/*= Yii::getAlias('@avatar') . $this->params['user']['avatar'] */?>"
                         class="thumbnail img-responsive" alt="user-avatar">
                    <div class="panel m-top-md">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-6 text-center">
                                    <span class="block font-14"><?/*= $this->params['userData']['following_count'] */?></span><br>
                                    <small class="text-muted"><?/*= Yii::t('app', 'Following') */?></small>
                                </div>

                                <div class="col-xs-6 text-center">
                                    <span class="block font-14"><?/*= $this->params['userData']['follower_count'] */?></span><br>
                                    <small class="text-muted"><?/*= Yii::t('app', 'Follower') */?></small>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php /*if (!empty($this->params['profile']['description'])): */?>
                        <h5 class="subtitle">About me</h5>
                        <p class="mb30"><?/*= Html::encode($this->params['profile']['description']) */?></p>
                    <?php /*endif */?>
                </div>
                <div class="col-sm-9">
                    <div class="profile-header">
                        <h2 class="profile-name">
                        <?/*= Html::a(Html::encode($this->params['user']['username']), ['/user/view', 'id' => Html::encode($this->params['user']['username'])]) */?>
                        </h2>
                        <?php /*if (!empty($this->params['profile']['address'])): */?>
                        <div class="profile-location"><i class="glyphicon glyphicon-map-marker"></i> <?/*= Html::encode($this->params['profile']['address']) */?> </div>
                        <?php /*endif */?>
                        <?php /*if (!empty($this->params['profile']['signature'])): */?>
                        <div class="profile-signature"><i class="glyphicon glyphicon-pushpin"></i> <?/*= Html::encode($this->params['profile']['signature']) */?> </div>
                        <?php /*endif */?>
                        <div class="mb20"></div>
                        <a class="btn btn-success follow" href="<?/*= Url::toRoute(['/user/user/follow', 'id' => $this->params['user']['id']]) */?>"><?/*= $followBtn */?></a>
                        <a class="btn btn-default"><i class="glyphicon glyphicon-envelope"></i> <?/*= Yii::t('app', 'Message') */?></a>

                    </div>

                </div>
            </div>-->

                <?= $content ?>

        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy;<?= Html::a(Yii::$app->setting->get('siteName'), ['/site/index']) ?><?= date('Y') ?>
                <?= Html::a(' 中文简体 ', '?lang=zh-CN') . '| ' . Html::a(' English ', '?lang=en') ?>
                <?= Yii::$app->setting->get('thirdPartyStatisticalCode') ?>
            </p>
            <p class="pull-right">十三平台</p>
        </div>
    </footer>
    <?php $this->endBody() ?>
    <script>
        $('.follow').on('click', function () {
            var a = $(this);
            $.ajax({
                url: a.attr('href'),
                success: function (data) {
                    if (data.action == 'create') {
                        a.html('取消关注');
                        history.go(0);

                    } else {
                        a.html('点击关注');
                        history.go(0);
                    }
                },
                error: function (XMLHttpRequest, textStatus) {
                    location.href = "<?= Url::toRoute(['/site/login']) ?>";
                }
            });
            return false;
        });
    </script>
    <?php \yii\myhelper\TotalCounter::counter(); ?>
    <div style="display: none;">
        <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1256948919'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/z_stat.php%3Fid%3D1256948919%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>
    </div>
    </body>
    </html>
<?php $this->endPage() ?>
