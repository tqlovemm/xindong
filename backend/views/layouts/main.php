<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$this->registerCssFile('@web/js/lightbox/css/lightbox.css');
$this->registerJsFile('@web/js/lightbox/js/lightbox.min.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <?php $this->head() ?>
    </head>
    <body class="sidebar-mini skin-blue-light">
    <?php $this->beginBody() ?>
    <div class="wrapper">
        <!-- header logo: style can be found in header.less -->
        <header class="main-header">
            <a href="#" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                十三交友平台 AdminLTE
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="pull-left">

                </div>

                <?php
                    $this->registerJs("
                        getMessage();
                    ");
                ?>

                <script>
                    function blink(selector){

                        $(selector).fadeOut('slow', function(){
                            $(this).fadeIn('slow', function(){
                                blink(this);
                            });
                        });
                    }

                    function getMessage() {
                        window.setInterval(function () {
                            $.get('/index.php/site/get-notice-message',function (data) {
                                var result = $.parseJSON(data);
                                $(".notice-message").before('<div class="blink" style="float: left;padding: 15px 15px;color:#fff;"><span>【'+result+'】</span></div>');
                                blink(".blink span");
                            });
                        }, 300000);
                    }
                </script>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?= Yii::$app->user->identity->username ?><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="<?= Yii::getAlias('@web/adminlte/img/user2-160x160.jpg') ?>" class="img-circle" alt="User Image" />
                                    <p>
                                        Jane Doe - Web Developer
                                        <small>Member since Nov. 2012</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?= URL::toRoute(['/site/logout']) ?>" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        <aside id="aside" class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="<?= Yii::getAlias('@web/adminlte/img/user2-160x160.jpg') ?>" class="img-circle" alt="User Image" />
                    </div>
                    <div class="pull-left info">
                        <p>Hello, <?= Yii::$app->user->identity->username ?></p>
                        <a href="<?= URL::toRoute(['/site/logout']) ?>" style="color:red;font-size: 14px;">退出</a>
                    </div>
                </div>
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <?php if(in_array(Yii::$app->user->id,[10005])):?><!--九五-->
                        <li>
                            <a href="<?= Url::toRoute(['/exciting/exciting']) ?>">
                                <i class="glyphicon glyphicon-heart"></i> <span>心动故事</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::toRoute(['/good/weichat-vote']) ?>">
                                <i class="glyphicon glyphicon-print"></i> <span>ID照发布</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::toRoute(['/good/weichat-dazzle']) ?>">
                                <i class="glyphicon glyphicon-print"></i> <span>炫腹季投票</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::toRoute(['/dating/dating']) ?>">
                                <i class="glyphicon glyphicon-gift"></i> <span>最新觅约</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::toRoute(['/flop/flop']) ?>">
                                <i class="glyphicon glyphicon-shopping-cart"></i> <span>翻牌</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::toRoute(['/collecting-file/thirth-files/have-no-file']) ?>">
                                <i class="glyphicon glyphicon-cog"></i> <span>新入会没有翻牌档案的编号</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::toRoute(['/collecting-file/thirth-files']) ?>">
                                <i class="glyphicon glyphicon-cog"></i> <span>13普通会员入会资料管理</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::toRoute(['/exciting/other-text']) ?>">
                                <i class="glyphicon glyphicon-cog"></i> <span>十三救火优质男女</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::toRoute(['/bgadmin/girl-default/index']) ?>">
                                <i class="glyphicon glyphicon-gift"></i> <span>十三平台女生会员跟踪列表</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::toRoute(['/exciting/website']) ?>">
                                <i class="glyphicon glyphicon-cog"></i> <span>网站联系我们二维码设置</span>
                            </a>
                        </li>
                    <?php endif;?>

                    <?php if(in_array(Yii::$app->user->id,[20952])):?><!--ximeng-->
                    <li style="padding:0 20px;font-size: 20px;background-color: #fff;color:orange;">十七平台</li>
                    <li class="treeview">
                        <a href="#">
                            <i>17</i>
                            <span>高端交友</span>
                            <i class="glyphicon glyphicon-menu-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">

                            <li><a href="<?= Url::toRoute(['/collecting-file/collecting-files']) ?>"><i class="glyphicon glyphicon-cog"></i> <span>17女生入会资料管理</span></a></li>
                            <li><a href="<?= Url::toRoute('/seventeen/seventeen-files-img') ?>"><i class="glyphicon glyphicon-picture"></i> <span>17女生图片资料管理</span></a></li>
                            <li><a href="<?= Url::toRoute(['/setting/default/send-collecting-seventeen-url']) ?>"><i class="glyphicon glyphicon-link"></i> <span>17女生信息收集链接</span></a></li>
                            <li><a href="<?= Url::toRoute(['/setting/default/send-seventeen-man-url']) ?>"><i class="glyphicon glyphicon-link"></i> <span>17男生微信打开链接</span></a></li>
                            <li><a href="<?= Url::toRoute('/seventeen/seventeen-wei-user') ?>"><i class="glyphicon glyphicon-cog"></i> <span>17男会员资料管理</span></a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i>17</i>
                            <span>会员信息跟踪</span>
                            <i class="glyphicon glyphicon-menu-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?= Url::toRoute(['/bgadmin/seventeen-default']) ?>">
                                    <i class="glyphicon glyphicon-gift"></i> <span>十七平台会员跟踪列表</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php endif;?>


                    <?php if(in_array(Yii::$app->user->id,[10028,20688])):?><!--徐冬冬-->
                    <!--APP-->
                    <li style="text-align: center;font-size: 20px;background-color: #fff;color:#0772ff;">APP</li>
                    <li class="treeview">
                        <a href="#">
                            <i>app</i>
                            <span>相关内容</span>
                            <i class="glyphicon glyphicon-menu-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?= Url::toRoute('/forum/forum/index') ?>"><i class="glyphicon glyphicon-baby-formula"></i> <span>朋友圈帖子管理</span></a></li>
                            <li>
                                <a href="<?= Url::toRoute(['/setting/app-version']) ?>">
                                    <i class="glyphicon glyphicon-phone"></i> <span class="text-red">版本控制（仅徐冬冬用）</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= Url::toRoute(['/setting/app-push-search']) ?>">
                                    <i class="glyphicon glyphicon-plane"></i> <span class="text-red">消息推送（闲人免用）</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= Url::toRoute(['/setting/member-ship']) ?>">
                                    <i class="glyphicon glyphicon-user"></i> <span>会员信誉度设置</span>
                                </a>
                            </li>
                            <li><a href="<?= Url::toRoute('/good/app-words/index') ?>"><i class="glyphicon glyphicon-baby-formula"></i> <span>新帖子管理</span></a></li>
                            <li>
                                <a href="<?= Url::toRoute(['/good/hx-group']) ?>">
                                    <i class="glyphicon glyphicon-user"></i> <span>app聊天群头像上传</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= Url::toRoute(['/app/audit']) ?>">
                                    <i class="glyphicon glyphicon-user"></i> <span>密约信息审核</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= Url::toRoute(['/app/turn-over-card']) ?>">
                                    <i class="glyphicon glyphicon-user"></i> <span>翻牌信息</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= Url::toRoute('/user') ?>">
                                    <i class="glyphicon glyphicon-cog"></i> <span>平台网站会员信息管理</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php endif;?>
                    <?php if(in_array(Yii::$app->user->id,[19179,18818])):?><!--张翠玲-->
                    <li>
                        <a href="<?= Url::toRoute(['/setting/default/send-collecting-url']) ?>">
                            <i class="glyphicon glyphicon-link"></i> <span>生成收集男生会员信息链接</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/collecting-file/thirth-files']) ?>">
                            <i class="glyphicon glyphicon-link"></i> <span>生成收集男生会员信息链接</span>
                        </a>
                    </li>

                    <?php endif;?>


                    <?php if(in_array(Yii::$app->user->id,[10000,10001,10002,10003,10015,20361])):?><!--超级管理员-->

                        <!--十三平台-->
                        <li style="font-size: 20px;color:red;padding:0 20px;">十三平台</li>
                        <li class="treeview">
                            <a href="#">
                                <i>13</i>
                                <span>节操币</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?= Url::toRoute(['/app/app-order']) ?>"><i class="glyphicon glyphicon-sd-video"></i> app充值记录</a></li>
                                <li><a href="<?= Url::toRoute(['/seek/alipay-coin-recharge-record']) ?>"><i class="glyphicon glyphicon-sd-video"></i> 支付宝充值统计</a></li>
                                <li><a href="<?= Url::toRoute(['/jiecao/jiecao-wxpay']) ?>"><i class="glyphicon glyphicon-hd-video"></i> 微信充值记录</a></li>
                                <li><a href="<?= Url::toRoute(['/jiecao/list']) ?>"><i class="glyphicon glyphicon-sort"></i> 调整会员节操币</a></li>
                                <li><a href="<?= Url::toRoute(['/jiecao/statistics']) ?>"><i class="glyphicon glyphicon-stats"></i> 节操币消费统计</a></li>
                                <li><a href="<?= Url::toRoute(['/jiecao/ranking-list']) ?>"><i class="glyphicon glyphicon-arrow-up"></i> 会员节操币排行榜</a></li>
                                <li>
                                    <a href="<?= Url::toRoute(['/setting/predefined-jiecao-coin']) ?>">
                                        <i class="glyphicon glyphicon-sort"></i> <span>节操币充值金额调整</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/jiecao/weipay-rank']) ?>">
                                        <i class="glyphicon glyphicon-sort"></i> <span>会员微信充值排名</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i>13</i>
                                <span>会员管理</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="<?= Url::toRoute(['/collecting-file/thirth-files']) ?>">
                                        <i class="glyphicon glyphicon-cog"></i> <span>平台入会表格资料管理</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/collecting-file/thirth-files/have-no-file?id=4']) ?>">
                                        <i class="glyphicon glyphicon-eye-open"></i> <span>入会无翻牌档案编号</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute('/user') ?>">
                                        <i class="glyphicon glyphicon-cog"></i> <span>平台网站会员信息管理</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/setting/default/send-collecting-url']) ?>">
                                        <i class="glyphicon glyphicon-link"></i> <span>生成收集男生会员信息链接</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/setting/member-sorts']) ?>">
                                        <i class="glyphicon glyphicon-queen"></i> <span>会员等级介绍和价格管理</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute('/user/user-info') ?>">
                                        <i class="glyphicon glyphicon-qrcode"></i> <span>会员详情信息查询</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/setting/member-ship']) ?>">
                                        <i class="glyphicon glyphicon-user"></i> <span>会员信誉度设置</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/setting/default/vip-temp']) ?>">
                                        <i class="glyphicon glyphicon-user"></i> <span>至尊高端试用包添加</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/setting/default/vip-temp-tj']) ?>">
                                        <i class="glyphicon glyphicon-user"></i> <span>至尊高端试用包统计</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i>13</i>
                                <span>会员反馈</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="<?= Url::toRoute(['/site/claims']) ?>">
                                        <i class="glyphicon glyphicon-wrench"></i> <span>举报投诉</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/site/feedback']) ?>">
                                        <i class="glyphicon glyphicon-road"></i> <span>会员反馈</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/dating/dating-cuicu']) ?>">
                                        <i class="glyphicon glyphicon-road"></i> <span>密约催促</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/dating/dating-vip']) ?>">
                                        <i class="glyphicon glyphicon-road"></i> <span>开通密约的人</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">
                                <i>13</i>
                                <span>消息管理</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="<?= Url::toRoute(['/setting/system-msg']) ?>">
                                        <i class="glyphicon glyphicon-comment"></i> <span>系统消息</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">
                                <i>13</i>
                                <span>投票管理</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                        <!--        <li>
                                    <a href="<?/*= Url::toRoute(['/note/note']) */?>">
                                        <i class="glyphicon glyphicon-print"></i> <span>炫腹肌投票</span>
                                    </a>
                                </li>-->
                                <li>
                                    <a href="<?= Url::toRoute(['/note/vote-sign-info']) ?>">
                                        <i class="glyphicon glyphicon-print"></i> <span>男神女神投票</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/good/weichat-vote']) ?>">
                                        <i class="glyphicon glyphicon-print"></i> <span>ID照发布</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/good/weichat-dazzle']) ?>">
                                        <i class="glyphicon glyphicon-print"></i> <span>炫腹季投票</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/active/new-year']) ?>">
                                        <i class="glyphicon glyphicon-print"></i> <span>新年投票</span>
                                    </a>
                                </li>
                            </ul>

                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i>13</i>
                                <span>网站内容管理</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="<?= Url::toRoute(['/dating/heart-week']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>心动周刊</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="<?= Url::toRoute(['/exciting/exciting']) ?>">
                                        <i class="glyphicon glyphicon-heart"></i> <span>心动故事</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/flop/flop']) ?>">
                                        <i class="glyphicon glyphicon-shopping-cart"></i> <span>翻牌资料</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/dating/dating']) ?>">
                                        <i class="glyphicon glyphicon-cog"></i> <span>最新觅约资料</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/exciting/other-text']) ?>">
                                        <i class="glyphicon glyphicon-cog"></i> <span>十三救火优质男女</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/good/check-service']) ?>">
                                        <i class="glyphicon glyphicon-cog"></i> <span>客服微信信息管理</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/setting']) ?>">
                                        <i class="glyphicon glyphicon-cog"></i> <span>网站seo设置</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/exciting/website']) ?>">
                                        <i class="glyphicon glyphicon-cog"></i> <span>网站联系我们二维码设置</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/good/user-how-play']) ?>">
                                        <i class="glyphicon glyphicon-cog"></i> <span>会员守则管理</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/good/default/index']) ?>">
                                        <i class="glyphicon glyphicon-cog"></i> <span>生活爆料</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i>13</i>
                                <span>觅约报名审核</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                                <li>
                                    <a href="<?= Url::toRoute(['/dating/dating-content/dating-signup-check']) ?>">
                                        <i class="glyphicon glyphicon-copy"></i> <span>私人客服审核</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/exciting/firefighters-sign-up']) ?>">
                                        <i class="glyphicon glyphicon-copy"></i> <span>救火福利审核</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/bgadmin/bgadmin-member-flop/flop-push']) ?>">
                                        <i class="glyphicon glyphicon-copy"></i> <span>翻牌审核</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/dating/dating-content/to-check']) ?>">
                                        <i class="glyphicon glyphicon-paste"></i> <span>转交客服组长审核</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/dating/dating-other']) ?>">
                                        <i class="glyphicon glyphicon-folder-open"></i> <span>觅约报名满10</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i>13</i>
                                <span>自动入会系统</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="<?= Url::toRoute(['/collecting-file/auto-join-link']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>自动入会链接详情</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/collecting-file/auto-join-record']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>自动入会记录</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/bgadmin/scan-weima-detail']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>生成十三平台分裂二维码</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i>13</i>
                                <span>会员信息跟踪</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="<?= Url::toRoute(['/bgadmin']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>十三平台男生会员跟踪列表</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/bgadmin/girl-default/index']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>十三平台女生会员跟踪列表</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/bgadmin/record']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>管理员操作跟踪</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/bgadmin/user-bg-record']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>会员节操币消费跟踪</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/bgadmin/user-weichat']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>微信绑定平台账号查询</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!--十七平台-->
                        <li style="padding:0 20px;font-size: 20px;background-color: #fff;color:orange;">十七平台</li>
                        <li class="treeview">
                            <a href="#">
                                <i>17</i>
                                <span>高端交友</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                                <li><a href="<?= Url::toRoute(['/collecting-file/collecting-files']) ?>"><i class="glyphicon glyphicon-cog"></i> <span>17女生入会资料管理</span></a></li>
                                <li><a href="<?= Url::toRoute('/seventeen/seventeen-files-img') ?>"><i class="glyphicon glyphicon-picture"></i> <span>17女生图片资料管理</span></a></li>
                                <li><a href="<?= Url::toRoute(['/setting/default/send-collecting-seventeen-url']) ?>"><i class="glyphicon glyphicon-link"></i> <span>17女生信息收集链接</span></a></li>
                                <li><a href="<?= Url::toRoute(['/setting/default/send-seventeen-man-url']) ?>"><i class="glyphicon glyphicon-link"></i> <span>17男生微信打开链接</span></a></li>
                                <li><a href="<?= Url::toRoute('/seventeen/seventeen-wei-user') ?>"><i class="glyphicon glyphicon-cog"></i> <span>17男会员资料管理</span></a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i>17</i>
                                <span>会员信息跟踪</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="<?= Url::toRoute(['/bgadmin/seventeen-default']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>十七平台会员跟踪列表</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!--APP-->
                        <li style="padding:0 20px;font-size: 20px;background-color: #fff;color:#0772ff;">APP</li>
                        <li class="treeview">
                            <a href="#">
                                <i>app</i>
                                <span>相关内容</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?= Url::toRoute('/forum/forum/index') ?>"><i class="glyphicon glyphicon-baby-formula"></i> <span>朋友圈帖子管理</span></a></li>
                                <li><a href="<?= Url::toRoute('/good/app-words/index') ?>"><i class="glyphicon glyphicon-baby-formula"></i> <span>新帖子管理</span></a></li>

                                <li>
                                    <a href="<?= Url::toRoute(['/setting/app-version']) ?>">
                                        <i class="glyphicon glyphicon-phone"></i> <span class="text-red">版本控制（仅徐冬冬用）</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/setting/app-push-search']) ?>">
                                        <i class="glyphicon glyphicon-plane"></i> <span class="text-red">消息推送（闲人免用）</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/setting/member-ship']) ?>">
                                        <i class="glyphicon glyphicon-user"></i> <span>会员信誉度设置</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/app/audit']) ?>">
                                        <i class="glyphicon glyphicon-user"></i> <span>密约信息审核</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/good/hx-group']) ?>">
                                        <i class="glyphicon glyphicon-user"></i> <span>app聊天群头像上传</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/app/turn-over-card']) ?>">
                                        <i class="glyphicon glyphicon-user"></i> <span>翻牌信息</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!--西蒙之家-->
                        <li style="padding:0 20px;font-size: 20px;background-color: #fff;color:#ff0688;">西檬之家</li>
                        <li class="treeview">
                            <a href="#">
                                <i>SM</i>
                                <span>会员信息跟踪</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="<?= Url::toRoute(['/bgadmin/sm-default']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>西檬之家会员跟踪列表</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/sm/default/send-collection-url']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>西檬之家会员信息录入表格</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/sm/sm-collection-files-text']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>西檬之家会员信息查询</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li style="padding:0 20px;font-size: 20px;background-color: #fff;color:#874fff;">地方啪</li>
                        <li class="treeview">
                            <a href="#">
                                <i>LOCAL</i>
                                <span>地方啪</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="<?= Url::toRoute(['/local/default/send-collection-url']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>地方啪会员信息录入表格</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/local/local-collection-files-text']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>地方啪会员信息查询</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif;?>
                    <?php if(in_array(Yii::$app->user->id,[10024,10004])):?><!--陈蕾，沈亚娜-->

                        <!--十三平台-->
                        <li style="font-size: 20px;color:red;padding:0 20px;">十三平台</li>
                        <li class="treeview">
                            <a href="#">
                                <i>13</i>
                                <span>节操币</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?= Url::toRoute(['/jiecao/jiecao-alipay']) ?>"><i class="glyphicon glyphicon-sd-video"></i> 支付宝充值记录</a></li>
                                <li><a href="<?= Url::toRoute(['/app/app-order']) ?>"><i class="glyphicon glyphicon-sd-video"></i> app充值记录</a></li>
                                <li><a href="<?= Url::toRoute(['/seek/alipay-coin-recharge-record']) ?>"><i class="glyphicon glyphicon-sd-video"></i> 支付宝充值统计</a></li>
                                <li><a href="<?= Url::toRoute(['/jiecao/jiecao-wxpay']) ?>"><i class="glyphicon glyphicon-hd-video"></i> 微信充值记录</a></li>
                                <li><a href="<?= Url::toRoute(['/jiecao/list']) ?>"><i class="glyphicon glyphicon-sort"></i> 调整会员节操币</a></li>
                                <li><a href="<?= Url::toRoute(['/jiecao/statistics']) ?>"><i class="glyphicon glyphicon-stats"></i> 节操币消费统计</a></li>
                                <li><a href="<?= Url::toRoute(['/jiecao/ranking-list']) ?>"><i class="glyphicon glyphicon-arrow-up"></i> 会员节操币排行榜</a></li>
                                <li>
                                    <a href="<?= Url::toRoute(['/setting/predefined-jiecao-coin']) ?>">
                                        <i class="glyphicon glyphicon-sort"></i> <span>节操币充值金额调整</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i>13</i>
                                <span>会员管理</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="<?= Url::toRoute(['/collecting-file/thirth-files']) ?>">
                                        <i class="glyphicon glyphicon-cog"></i> <span>平台入会表格资料管理</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/collecting-file/thirth-files/have-no-file?id=4']) ?>">
                                        <i class="glyphicon glyphicon-eye-open"></i> <span>入会无翻牌档案编号</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute('/user') ?>">
                                        <i class="glyphicon glyphicon-cog"></i> <span>平台网站会员信息管理</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/setting/default/send-collecting-url']) ?>">
                                        <i class="glyphicon glyphicon-link"></i> <span>生成收集男生会员信息链接</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/setting/member-sorts']) ?>">
                                        <i class="glyphicon glyphicon-queen"></i> <span>会员等级介绍和价格管理</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute('/user/user-info') ?>">
                                        <i class="glyphicon glyphicon-qrcode"></i> <span>会员详情信息查询</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/setting/member-ship']) ?>">
                                        <i class="glyphicon glyphicon-user"></i> <span>会员信誉度设置</span>
                                    </a>
                                </li>
                               <!-- <li><a href="<?/*= Url::toRoute('/user/user-dating') */?>"><i class="glyphicon glyphicon-menu-right"></i> 会员觅约记录</a></li>-->
                               <!-- <li><a href="<?/*= Url::toRoute('/post') */?>"><i class="glyphicon glyphicon-menu-right"></i>博客</a></li>-->
                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i>13</i>
                                <span>会员反馈</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="<?= Url::toRoute(['/site/claims']) ?>">
                                        <i class="glyphicon glyphicon-wrench"></i> <span>举报投诉</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/site/feedback']) ?>">
                                        <i class="glyphicon glyphicon-road"></i> <span>会员反馈</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                   <!--     <li class="treeview">
                            <a href="#">
                                <i class="glyphicon glyphicon-hdd"></i>
                                <span>审核</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?/*=Url::toRoute(['/site/file-check'])*/?>"><i class="glyphicon glyphicon-menu-right"></i>档案照审核</a></li>
                            </ul>
                        </li>-->


                        <li>
                            <a href="#">
                                <i>13</i>
                                <span>消息管理</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                                <li>
                                    <a href="<?= Url::toRoute(['/setting/system-msg']) ?>">
                                        <i class="glyphicon glyphicon-comment"></i> <span>系统消息</span>
                                    </a>
                                </li>

                            </ul>

                        </li>
                        <li>
                            <a href="#">
                                <i>13</i>
                                <span>投票管理</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                        <!--        <li>
                                    <a href="<?/*= Url::toRoute(['/note/note']) */?>">
                                        <i class="glyphicon glyphicon-print"></i> <span>炫腹肌投票</span>
                                    </a>
                                </li>-->
                                <li>
                                    <a href="<?= Url::toRoute(['/note/vote-sign-info']) ?>">
                                        <i class="glyphicon glyphicon-print"></i> <span>男神女神投票</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/good/weichat-vote']) ?>">
                                        <i class="glyphicon glyphicon-print"></i> <span>ID照发布</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/good/weichat-dazzle']) ?>">
                                        <i class="glyphicon glyphicon-print"></i> <span>炫腹季投票</span>
                                    </a>
                                </li>
                            </ul>

                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i>13</i>
                                <span>网站内容管理</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="<?= Url::toRoute(['/dating/heart-week']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>心动周刊</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="<?= Url::toRoute(['/exciting/exciting']) ?>">
                                        <i class="glyphicon glyphicon-heart"></i> <span>心动故事</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/flop/flop']) ?>">
                                        <i class="glyphicon glyphicon-shopping-cart"></i> <span>翻牌资料</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/dating/dating']) ?>">
                                        <i class="glyphicon glyphicon-cog"></i> <span>最新觅约资料</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/exciting/other-text']) ?>">
                                        <i class="glyphicon glyphicon-cog"></i> <span>十三救火优质男女</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/good/check-service']) ?>">
                                        <i class="glyphicon glyphicon-cog"></i> <span>客服微信信息管理</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/setting']) ?>">
                                        <i class="glyphicon glyphicon-cog"></i> <span>网站seo设置</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/exciting/website']) ?>">
                                        <i class="glyphicon glyphicon-cog"></i> <span>网站联系我们二维码设置</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/good/user-how-play']) ?>">
                                        <i class="glyphicon glyphicon-cog"></i> <span>会员守则管理</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/good/default/index']) ?>">
                                        <i class="glyphicon glyphicon-cog"></i> <span>生活爆料</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i>13</i>
                                <span>觅约报名审核</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                                <li>
                                    <a href="<?= Url::toRoute(['/dating/dating-content/dating-signup-check']) ?>">
                                        <i class="glyphicon glyphicon-copy"></i> <span>私人客服审核</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/exciting/firefighters-sign-up']) ?>">
                                        <i class="glyphicon glyphicon-copy"></i> <span>救火福利审核</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/bgadmin/bgadmin-member-flop/flop-push']) ?>">
                                        <i class="glyphicon glyphicon-copy"></i> <span>翻牌审核</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/dating/dating-content/to-check']) ?>">
                                        <i class="glyphicon glyphicon-paste"></i> <span>转交客服组长审核</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/dating/dating-other']) ?>">
                                        <i class="glyphicon glyphicon-folder-open"></i> <span>觅约报名满10</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i>13</i>
                                <span>自动入会系统</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="<?= Url::toRoute(['/collecting-file/auto-join-link']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>自动入会链接详情</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/collecting-file/auto-join-record']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>自动入会记录</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/bgadmin/scan-weima-detail']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>生成十三平台分裂二维码</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i>13</i>
                                <span>会员信息跟踪</span>
                                <i class="glyphicon glyphicon-menu-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="<?= Url::toRoute(['/bgadmin']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>十三平台男生会员跟踪列表</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/bgadmin/girl-default/index']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>十三平台女生会员跟踪列表</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/bgadmin/record']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>管理员操作跟踪</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/bgadmin/user-bg-record']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>会员节操币消费跟踪</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['/bgadmin/user-weichat']) ?>">
                                        <i class="glyphicon glyphicon-gift"></i> <span>微信绑定平台账号查询</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif;?>
                    <?php if(in_array(Yii::$app->user->id,[10020,10021])):?><!--jiangxiaohua sunyuntong-->
                    <li>
                        <a href="<?= Url::toRoute(['/collecting-file/auto-join-link']) ?>">
                            <i class="glyphicon glyphicon-gift"></i> <span>自动入会链接详情</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/collecting-file/auto-join-record']) ?>">
                            <i class="glyphicon glyphicon-gift"></i> <span>自动入会记录</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/bgadmin/scan-weima-detail']) ?>">
                            <i class="glyphicon glyphicon-gift"></i> <span>生成十三平台分裂二维码</span>
                        </a>
                    </li>

                <?php endif;?>
                <?php if(in_array(Yii::$app->user->id,[10025,10019])):?><!--沈川 李青-->
                    <!--西蒙之家-->
                    <li style="padding:0 20px;font-size: 20px;background-color: #fff;color:#ff0688;">西檬之家</li>
                    <li class="treeview">
                        <a href="#">
                            <i>SM</i>
                            <span>会员信息跟踪</span>
                            <i class="glyphicon glyphicon-menu-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">

                            <li>
                                <a href="<?= Url::toRoute(['/sm/default/send-collection-url']) ?>">
                                    <i class="glyphicon glyphicon-gift"></i> <span>生成西檬之家会员信息录入表格链接</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= Url::toRoute(['/sm/sm-collection-files-text']) ?>">
                                    <i class="glyphicon glyphicon-gift"></i> <span>查看西檬之家会员信息</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= Url::toRoute(['/bgadmin/sm-default']) ?>">
                                    <i class="glyphicon glyphicon-gift"></i> <span>西檬之家会员跟踪列表</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif;?>
                <?php if(in_array(Yii::$app->user->id,[10010,10018])):?><!--代婉仪 王志峰-->
                    <li style="padding:0 20px;font-size: 20px;background-color: #fff;color:#874fff;">地方啪</li>
                    <li class="treeview">
                        <a href="#">
                            <i>LOCAL</i>
                            <span>地方啪</span>
                            <i class="glyphicon glyphicon-menu-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?= Url::toRoute(['/local/default/send-collection-url']) ?>">
                                    <i class="glyphicon glyphicon-gift"></i> <span>生成地方啪会员信息录入表格链接</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= Url::toRoute(['/local/local-collection-files-text']) ?>">
                                    <i class="glyphicon glyphicon-gift"></i> <span>查看地方啪会员信息</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif;?>

                <?php if(in_array(Yii::$app->user->id,[10016])):?><!--smzj13_lxn--刘小宁/smpt666_xmx--谢美霞-->
                    <li>
                        <a href="<?= Url::toRoute(['/collecting-file/thirth-files']) ?>">
                            <i class="glyphicon glyphicon-cog"></i> <span>平台入会表格资料管理</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/setting/default/send-collecting-url']) ?>">
                            <i class="glyphicon glyphicon-link"></i> <span>生成收集男生会员信息链接</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/dating/dating']) ?>">
                            <i class="glyphicon glyphicon-cog"></i> <span>最新觅约资料</span>
                        </a>
                    </li>
                    <?php endif;?>

                    <?php if(in_array(Yii::$app->user->id,[10029])):?><!--财务-->
                    <li><a href="<?= Url::toRoute(['/app/app-order']) ?>"><i class="glyphicon glyphicon-sd-video"></i> app充值记录</a></li>
                    <li><a href="<?= Url::toRoute(['/jiecao/jiecao-wxpay']) ?>"><i class="glyphicon glyphicon-hd-video"></i> 微信充值记录</a></li>
                    <li><a href="<?= Url::toRoute(['/seek/alipay-coin-recharge-record']) ?>"><i class="glyphicon glyphicon-sd-video"></i> 支付宝充值统计</a></li>
                    <?php endif;?>
                    <?php if(in_array(Yii::$app->user->id,[10009,21029])):?><!--shisankefu_cgh--陈国华,蒋程强-->
                    <li>
                        <a href="<?= Url::toRoute(['/setting/default/send-collecting-url']) ?>">
                            <i class="glyphicon glyphicon-link"></i> <span>生成收集男生会员信息链接</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/bgadmin/user-bg-record']) ?>">
                            <i class="glyphicon glyphicon-gift"></i> <span>会员节操币消费跟踪</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/dating/dating-content/dating-signup-check']) ?>">
                            <i class="glyphicon glyphicon-copy"></i> <span>私人客服审核</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/bgadmin/bgadmin-member-flop/flop-push']) ?>">
                            <i class="glyphicon glyphicon-copy"></i> <span>翻牌审核</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/exciting/firefighters-sign-up']) ?>">
                            <i class="glyphicon glyphicon-copy"></i> <span>救火福利审核</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/collecting-file/thirth-files']) ?>">
                            <i class="glyphicon glyphicon-cog"></i> <span>平台入会表格资料管理</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/jiecao/reduce']) ?>">
                            <i class="glyphicon glyphicon-cog"></i> <span>减少会员节操币</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/flop/flop-content-search']) ?>">
                            <i class="glyphicon glyphicon-link"></i> <span>翻牌资料搜索</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/bgadmin']) ?>">
                            <i class="glyphicon glyphicon-gift"></i> <span>十三平台男生会员跟踪列表</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/bgadmin/girl-default/index']) ?>">
                            <i class="glyphicon glyphicon-gift"></i> <span>十三平台女生会员跟踪列表</span>
                        </a>
                    </li>
                    <li>
                    <a href="<?= Url::toRoute(['/bgadmin/user-weichat']) ?>">
                        <i class="glyphicon glyphicon-gift"></i> <span>微信绑定平台账号查询</span>
                    </a>
                    <li>
                    <li><a href="<?= Url::toRoute(['/jiecao/statistics']) ?>"><i class="glyphicon glyphicon-stats"></i> 节操币消费统计</a></li>
                    <li><a href="<?= Url::toRoute(['/jiecao/ranking-list']) ?>"><i class="glyphicon glyphicon-arrow-up"></i> 会员节操币排行榜</a></li>
                <?php endif;?>
                    <?php if(in_array(Yii::$app->user->id,[10026,10022,20952])):?><!--bb13love_cl--曹莉,feroinababe--黄嘉庆-->
                    <li>
                        <a href="<?= Url::toRoute(['/collecting-file/thirth-files']) ?>">
                            <i class="glyphicon glyphicon-cog"></i> <span>平台入会表格资料管理</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute('/user') ?>">
                            <i class="glyphicon glyphicon-cog"></i> <span>平台网站会员信息管理</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/setting/default/send-collecting-url']) ?>">
                            <i class="glyphicon glyphicon-link"></i> <span>生成收集男生会员信息链接</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/bgadmin/user-bg-record']) ?>">
                            <i class="glyphicon glyphicon-gift"></i> <span>会员节操币消费跟踪</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/dating/dating-content/to-check']) ?>">
                            <i class="glyphicon glyphicon-paste"></i> <span>转交客服组长审核</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/flop/flop-content-search']) ?>">
                            <i class="glyphicon glyphicon-link"></i> <span>翻牌资料搜索</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/bgadmin']) ?>">
                            <i class="glyphicon glyphicon-gift"></i> <span>十三平台男生会员跟踪列表</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/bgadmin/girl-default/index']) ?>">
                            <i class="glyphicon glyphicon-gift"></i> <span>十三平台女生会员跟踪列表</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/exciting/other-text']) ?>">
                            <i class="glyphicon glyphicon-cog"></i> <span>十三救火优质男女</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/exciting/firefighters-sign-up']) ?>">
                            <i class="glyphicon glyphicon-copy"></i> <span>救火福利审核</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/bgadmin/bgadmin-member-flop/flop-push']) ?>">
                            <i class="glyphicon glyphicon-copy"></i> <span>翻牌审核</span>
                        </a>
                    </li>
                <?php endif;?>
                    <?php if(in_array(Yii::$app->user->id,[10016])):?><!--smpt666_xmx--谢美霞-->
                    <!--西蒙之家-->
                    <li style="padding:0 20px;font-size: 20px;background-color: #fff;color:#ff0688;">西檬之家</li>
                    <li class="treeview">
                        <a href="#">
                            <i>SM</i>
                            <span>会员信息跟踪</span>
                            <i class="glyphicon glyphicon-menu-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?= Url::toRoute(['/bgadmin/sm-default']) ?>">
                                    <i class="glyphicon glyphicon-gift"></i> <span>西檬之家会员跟踪列表</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif;?>
                    <?php if(in_array(Yii::$app->user->id,[16310])):?><!--wangzhifeng-->
                    <li>
                        <a href="<?= Url::toRoute(['/bgadmin/user-bg-record']) ?>">
                            <i class="glyphicon glyphicon-gift"></i> <span>会员节操币消费跟踪</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/flop/flop']) ?>">
                            <i class="glyphicon glyphicon-shopping-cart"></i> <span>翻牌资料</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/collecting-file/thirth-files']) ?>">
                            <i class="glyphicon glyphicon-cog"></i> <span>平台入会表格资料管理</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/dating/dating-content/dating-signup-check']) ?>">
                            <i class="glyphicon glyphicon-copy"></i> <span>私人客服审核</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/bgadmin/bgadmin-member-flop/flop-push']) ?>">
                            <i class="glyphicon glyphicon-copy"></i> <span>翻牌审核</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/jiecao/reduce']) ?>">
                            <i class="glyphicon glyphicon-cog"></i> <span>减少会员节操币</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/bgadmin']) ?>">
                            <i class="glyphicon glyphicon-gift"></i> <span>十三平台男生会员跟踪列表</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/bgadmin/girl-default/index']) ?>">
                            <i class="glyphicon glyphicon-gift"></i> <span>十三平台女生会员跟踪列表</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/bgadmin/sm-default']) ?>">
                            <i class="glyphicon glyphicon-gift"></i> <span>西檬之家会员跟踪列表</span>
                        </a>
                    </li>
                <?php endif;?>
                    <li>
                        <a href="<?= Url::toRoute(['/seek/service-patters']) ?>">
                            <i class="glyphicon glyphicon-user"></i> <span>经典话术</span>
                        </a>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Right side column. Contains the navbar and content of the page -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <?= \Yii::$app->controller->module->id ?>
                    <small>Preview page</small>
                </h1>
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </section>

            <!-- Main content -->
            <section class="content">
                <?= Alert::widget() ?>
                <?= $content ?>
            </section><!-- /.content -->
        </div><!-- /.right-side -->
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy;</p>
            <p class="pull-right">三十一天</p>
        </div>
    </footer>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>