<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Breadcrumbs;
use app\themes\basic\modules\user\AppAsset;
use frontend\widgets\Alert;
use yii\widgets\ActiveForm;
use app\modules\forum\models\Thread;
/* @var $this \yii\web\View */
/* @var $content string */
/* @var $user string */
$user = Yii::$app->user->identity;

$unReadMessageCount = $user->unReadMessageCount;
AppAsset::register($this);
$this->registerCss('
#top-nav.skin-1{background: rgba(198, 81, 81,1);border-bottom:1px solid rgba(198, 81, 81,1);}
#top-nav.skin-1 .brand{background: rgba(198, 81, 81,1);}
aside.skin-1 .main-menu > ul > li > a:hover{background:rgba(198, 81, 81,1);}
aside.skin-1 .main-menu > ul > li > a .menu-hover{background:rgba(198, 81, 81,1);box-shadow:none;}
#wrapper{width:1200px !important;}
.line-note{margin: 0 15%;border-right: 1px solid #bebebe;width: 1px;height: 15px;}
.note-a a{color:gray;}
.note-a a:hover{color:red !important;}
@media (min-width:768px){
    #wrapper.sidebar-mini #top-nav .brand {width: 89px !important;}
}
@media (max-width:560px){
    #wrapper{width:auto !important;}
    #top-nav{width:150% !important;}
    .line-note{margin: 0 4%;border-right: 1px solid #bebebe;width: 1px;height: 15px;}
}
@media (max-width:380px){
    #top-nav{width:155% !important;}
}
@media (max-width:340px){
    #top-nav{width:165% !important;}
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
    <body class="overflow-hidden layout-boxed">
    <?php $this->beginBody() ?>
    <div id="wrapper">

        <header id="top-nav" class="fixed skin-1">
            <a href="/" class="brand">
                <img src="<?=Yii::getAlias('@web')?>/images/weixin/littlelogo.gif"><span><?= Yii::$app->setting->get('siteName') ?></span>
            </a><!-- /brand -->
            <button type="button" class="navbar-toggle pull-left" id="sidebarToggle">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <button type="button" class="navbar-toggle pull-left hide-menu" id="menuToggle">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <ul class="nav-notification clearfix">
                <li class="dropdown visible-xs">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-home">导航</i>
                        <span><i class="glyphicon glyphicon-chevron-down"></i></span>
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="clearfix" href="/forums?sort=-t.created_at">
                                <i class="glyphicon glyphicon-home"></i>
                                首页
                            </a>
                        </li>
                        <li>
                            <a tabindex="-1" href="/u/<?=Yii::$app->user->identity->username?>" class="main-link">
                                <i class="glyphicon glyphicon-user"></i>
                                个人主页
                            </a>
                        </li>
                        <li>
                            <a tabindex="-1" href="/user/message" class="theme-setting">
                                <i class="glyphicon glyphicon-envelope"></i>
                                消息
                                <span class="badge badge-success notification-label bounceIn animation-delay4"><?= $unReadMessageCount  ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown hidden-xs">
                    <a class="dropdown-toggle" href="/forums?sort=-t.created_at">
                        <i class="glyphicon glyphicon-home">首页</i>
                    </a>
                </li>
                <li class="dropdown hidden-xs">
                    <a class="dropdown-toggle" href="/u/<?=Yii::$app->user->identity->username?>">
                        <i class="glyphicon glyphicon-user">个人主页</i>
                    </a>
                </li>
                <li class="dropdown hidden-xs">
                    <a class="dropdown-toggle" href="/user/message">
                        <i class="glyphicon glyphicon-envelope">消息提醒</i>

                        <span class="badge badge-success notification-label bounceIn animation-delay4"><?= $unReadMessageCount  ?></span>

                    </a>
                    <!--<ul class="dropdown-menu message dropdown-1">
                        <li><a>You have <?/*= $unReadMessageCount */?> new unread messages</a></li>
                        <li>
                            <a class="clearfix" href="#">
                                <img src="<?/*= Yii::getAlias('@avatar'). $user->avatar */?>" alt="User Avatar">
                                <div class="detail">
                                    <strong>John Doe</strong>
                                    <p class="no-margin">
                                        Lorem ipsum dolor sit amet...
                                    </p>
                                    <small class="text-muted"><i class="fa fa-check text-success"></i> 27m ago</small>
                                </div>
                            </a>
                        </li>
                        <li><a href="#">View all messages</a></li>
                    </ul>-->
                </li>
                <li class="profile dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span><i class="glyphicon glyphicon-cog"></i></span>
                        <strong>
                            <?php if(!empty($user->nickname)){echo Html::encode($user->nickname);}else{echo Html::encode($user->username);} ?>

                        </strong>
                        <span><i class="glyphicon glyphicon-chevron-down"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="clearfix" href="#">
                                <img src="<?= $user->avatar ?>" alt="十三平台头像">
                                <div class="detail">
                                    <strong> <?php if(!empty($user->nickname)){echo Html::encode($user->nickname);}else{echo Html::encode($user->username);} ?></strong>
                                    <p class="grey"><?= Html::encode($user->email) ?></p>
                                </div>
                            </a>
                        </li>
                        <li><a tabindex="-1" href="<?= Url::toRoute(['/user/view', 'id' => $user->username]) ?>" class="main-link"><i class="glyphicon glyphicon-edit"></i>个人主页</a></li>
                        <li><a tabindex="-1" href="<?= Url::toRoute(['/user/setting']) ?>" class="theme-setting"><i class="glyphicon glyphicon-cog"></i> 设置</a></li>
                        <li class="divider"></li>
                        <li>
                            <a tabindex="-1" class="main-link" data-toggle="modal" data-target="#logoutConfirm">
                                <i class="glyphicon glyphicon-log-out"></i>
                                退出</a>
                        </li>
                    </ul>
                </li>
                <li><a style="cursor: pointer;" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-pencil"></i></a></li>
            </ul>
        </header><!-- /top-nav-->
        <!--发帖弹出框-->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <?php $newThread = new Thread(); ?>
                        <?= $this->render('/thread/_form', ['model' => $newThread,]) ?>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal -->
            </div>
        </div>
        <aside class="fixed skin-1 home-hidden" style="background: rgba(42, 42, 42,1);">
            <div class="sidebar-inner scrollable-sidebar" style="overflow: hidden; height: 100%;">
                <!--<div class="size-toggle">
                    <a class="btn btn-sm" id="sizeToggle">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="btn btn-sm pull-right" data-toggle="modal" data-target="#logoutConfirm">
                        <i class="glyphicon glyphicon-off"></i>
                    </a>
                </div>--><!-- /size-toggle -->

                <!-- <div class="user-block clearfix">
                    <img src="<?/*= Yii::getAlias('@avatar'). $user->avatar */?>" alt="User Avatar">
                    <div class="detail">
                        <ul class="list-inline">
                            <li>
                                <a href="<?/*= Url::toRoute(['/user/view', 'id' => $user->username]) */?>">
                                    <i class="glyphicon glyphicon-new-window"></i> <strong><?/*= Html::encode($user->username) */?></strong>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>-->


                <!-- /user-block -->
                <!--  <div class="search-block">
                      <div class="input-group">
                          <input type="text" class="form-control input-sm" placeholder="search here...">
                      <span class="input-group-btn">
                          <button class="btn btn-default btn-sm" type="button"><i class="glyphicon glyphicon-search"></i></button>
                      </span>
                      </div> /input-group
                  </div>--><!-- /search-block -->

                <br>
                <div class="main-menu">
                    <ul>

                        <li <?php if(Yii::$app->request->getPathInfo()=='forums' ){echo 'style="background: rgba(198, 81, 81,1);"';}?>>
                            <a href="<?= Url::toRoute(['/forums?sort=-t.created_at']) ?>">
                            <span class="menu-icon">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </span>
                            <span class="text">
                                首页
                            </span>
                                <!--       <span class="badge badge-danger bounceIn animation-delay6"><?/*= $unReadMessageCount */?></span>-->
                                <span class="menu-hover"></span>
                            </a>
                        </li>
                        <li <?php if(Yii::$app->request->getPathInfo()=='show/ingids' ){echo 'style="background: rgba(198, 81, 81,1);"';}?>>
                            <a href="<?= Url::toRoute(['/show/ingids','sort'=>'-created_at']) ?>">
                            <span class="menu-icon">
                                <i class="glyphicon glyphicon-picture"></i>
                            </span>
                            <span class="text">
                                最in ID照
                            </span>

                                <span class="menu-hover"></span>
                            </a>
                        </li>

                        <li <?php if(Yii::$app->request->getPathInfo()=='home/post'){echo 'style="background: rgba(198, 81, 81,1);"';}?>>
                            <a href="<?= Url::toRoute(['/home/post']) ?>">
                            <span class="menu-icon">
                                <i class="glyphicon glyphicon-list-alt"></i>
                            </span>
                            <span class="text">
                                私密日志
                            </span>
                                <span class="menu-hover"></span>
                            </a>
                        </li>

                        <li <?php if(Yii::$app->request->getPathInfo()=='home/album'){echo 'style="background: rgba(198, 81, 81,1);"';}?>>
                            <a href="<?= Url::toRoute('/home/album') ?>">
                            <span class="menu-icon">
                                <i class="glyphicon glyphicon-picture"></i>
                            </span>
                            <span class="text">
                                我的相册
                            </span>
                                <span class="menu-hover"></span>
                            </a>
                        </li>
                        <!-- <li>
                            <a href="<?/*= Url::toRoute(['/user/dashboard']) */?>">
                            <span class="menu-icon">
                                <i class="glyphicon glyphicon-home"></i>
                            </span>
                            <span class="text">
                                <?/*= Yii::t('app', 'Net Home') */?>
                            </span>
                                <span class="menu-hover"></span>
                            </a>
                        </li>-->


                        <li <?php if(Yii::$app->request->getPathInfo()=='user/claims'){echo 'style="background: rgba(198, 81, 81,1);"';}?>>
                            <a href="<?= Url::toRoute('/user/claims') ?>">
                            <span class="menu-icon">
                                <i class="glyphicon glyphicon-globe"></i>
                            </span>
                            <span class="text">
                               举报投诉
                            </span>
                                <span class="menu-hover"></span>
                            </a>
                        </li>


                        <!-- <li>
                            <a href="<?/*= Url::toRoute('/home/todu/video') */?>">
                            <span class="menu-icon">
                                <i class="glyphicon glyphicon-facetime-video"></i>
                            </span>
                            <span class="text">
                                <?/*= Yii::t('app', 'Video') */?>
                            </span>
                                <span class="menu-hover"></span>
                            </a>
                        </li>-->
                        <li data-toggle="modal" data-target="#myModalf" style="cursor: pointer;">
                            <!--<a href="<?/*= Url::toRoute(['/attention/feedback']) */?>">-->
                            <a>
                            <span class="menu-icon">
                                <i class="glyphicon glyphicon-share-alt"></i>
                            </span>
                            <span class="text">
                                反馈
                            </span>
                                <span class="menu-hover"></span>
                            </a>
                        </li>
                        <!-- 模态框（Modal） -->

                        <!--        <li>
                            <a href="<?/*= Url::toRoute(['/user/message']) */?>">
                            <span class="menu-icon">
                                <i class="glyphicon glyphicon-envelope"></i>
                            </span>
                            <span class="text">
                                <?/*= Yii::t('app', 'My Notification') */?>
                            </span>
                                <span class="badge badge-danger bounceIn animation-delay6"><?/*= $unReadMessageCount */?></span>
                                <span class="menu-hover"></span>
                            </a>
                        </li>-->

                        <!--  <li>
                            <a href="<?/*= Url::toRoute(['/home/seek/view','id'=>Album::find()->one()->toArray()['id']]) */?>">
                            <span class="menu-icon">
                                <i class="glyphicon glyphicon-hdd"></i>
                            </span>
                            <span class="text">
                                <?/*= Yii::t('app', 'Seek') */?>
                            </span>
                                <span class="badge badge-danger bounceIn animation-delay6"><?/*= $unReadMessageCount */?></span>
                                <span class="menu-hover"></span>
                            </a>
                        </li>-->



                        <!--<li>
                            <a href="http://www.iisns.com/forum/iisns">
                            <span class="menu-icon">
                                <i class="glyphicon glyphicon-question-sign"></i>
                            </span>
                            <span class="text">
                                <?/*= Yii::t('app', 'Help') */?>
                            </span>
                                <span class="menu-hover"></span>
                            </a>
                        </li>-->
                    </ul>
                </div><!-- /main-menu -->
            </div>
            <!-- /sidebar-inner -->
        </aside>

        <!-- 模态框（Modal） -->
        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close"
                                data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            通知
                        </h4>
                    </div>
                    <div class="modal-body text-center">
                        <span class="text-danger">近期即将开放</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
        <div class="modal fade" id="myModalf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close"
                                data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $model = new \frontend\models\Feedback();
                        $form = ActiveForm::begin([

                            'action' => ['/attention/feedback'],
                            'method'=>'post',
                        ])?>

                        <?=$form->field($model, 'title')->textInput(['maxlength' =>125]) ?>
                        <?=$form->field($model, 'content')->textarea(['rows'=>5]) ?>
                        <?php
                        if(!empty(Yii::$app->user->identity->username)):
                            ?>
                            <?=Html::activeHiddenInput($model,'created_by',['value'=>Yii::$app->user->identity->username])?>

                        <?php endif; ?>

                        <?=Html::activeHiddenInput($model,'created_at',['value'=>time()])?>
                        <?= Html::submitButton('提交', ['class'=>'btn btn-primary','name' =>'submit-button']) ?>
                        <?= Html::resetButton('重置', ['class'=>'btn btn-primary','name' =>'submit-button']) ?>

                        <?php $form = ActiveForm::end()?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>

        <div id="main-container">
            <div id="breadcrumb">
                <?= Breadcrumbs::widget([
                    'homeLink' => ['label' => '首页', 'url' => ['/forums?sort=-t.created_at']],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </div><!-- /breadcrumb-->

            <div class="padding-md">
                <?= Alert::widget() ?>
                <div class="container-fluid">
                    <?= $content ?>
                </div>
            </div><!-- /.padding-md -->
        </div>
        <footer>
            <div class="row">
                <div class="col-sm-6">
                    <p class="no-margin">
                        &copy; <?= date('Y') ?> <strong><?= Html::a(Yii::$app->setting->get('siteName'), ['/']) ?></strong>
                        <?= Yii::$app->setting->get('thirdPartyStatisticalCode') ?>
                    </p>
                </div><!-- /.col -->
            </div><!-- /.row-->
        </footer>
    </div>
<!--    <div id="scroll-to-top"><span class="glyphicon glyphicon-menu-up"></span></div>-->
    <?php
    Modal::begin([
        'id' => 'logoutConfirm',
        'header' => '<h2>退出</h2>',
        'footer' => Html::a('退出', ['/logout'], ['class' => 'btn btn-default'])
    ]);
    echo '您确定退出';
    Modal::end();
    ?>
    <?php $this->endBody() ?>

    <div style="display: none;">
        <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1256948919'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/z_stat.php%3Fid%3D1256948919%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>
    </div>
    </body>
</html>
<?php $this->endPage() ?>
