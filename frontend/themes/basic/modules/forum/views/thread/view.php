<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use yii\myhelper\Helper;
use app\modules\user\models\User;
use yii\web\View;
$seoInfo = $model->seoInfo;
$this->title = $seoInfo['title'];
$this->registerMetaTag(['name' => 'keywords', 'content' => $seoInfo['keywords']]);
$this->registerMetaTag(['name' => 'description', 'content' => $seoInfo['description']]);
$this->params['forum'] = $model->forum;
$user = $model->user;
$posts = $model->posts;

$this->registerCss('

    .home-hidden{display:none;}
    #top-nav .navbar-toggle.hide-menu{display:none;}
    #main-container{margin-left:0 !important;}
    #top-nav{width:1200px !important;}
    .padding-md{padding:0 15px !important;}
    ul{padding:0 !important;margin:0 !important;}
    footer{margin-left:0px;}
   .content-img img{width:150px;height:100px;}
    #wrapper.sidebar-mini #main-container{margin-left:0;}
    .post-bg{background-color: white;padding:10px 20px;margin-bottom:15px;}
    .PlusView-largeBg {
        background: gray;
        text-align: center;
        position: relative;
        width:100%;
        padding: 0px;
        zoom: 1;
    }
    @media (max-width:768px){
    .content-img img{width:75px;height:70px;}
        .name-time{line-height:100px;}
       #top-nav{width:auto !important;}
       .post-bg{margin-left:0;}

}

');
?>
<?php $this->registerJsFile("/js/jquery-1.11.3.js",['position' => View::POS_HEAD]);
$this->registerJsFile('@web/js/lightbox/js/lightbox.min.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);
$this->registerCssFile('@web/js/lightbox/css/lightbox.css');
?>

<br>
<div class="row">
    <div class="col-md-9">
        <div style="background-color: white;padding:10px;">
                <div class="pull-left" style="margin-right: 10px;">
                    <img style="width: 80px;margin-bottom: 5px;" class="img-user img-circle" src="<?= $user['avatar'] ?>" alt="十三平台">
                    <br>
                    <?php if($user['id']!=Yii::$app->user->id){?>
                    <a class="btn btn-default btn-sm center-block" onclick="return note(<?=$user['id']?>)">
                            <span id="follow">
                                <?php if(User::getIsFollow($user['id'])){echo '已关注';}else{?>
                                    <i class="glyphicon glyphicon-plus text-danger"></i>关注<?php }?>
                            </span>
                    </a>
                    <?php }?>
                </div>

                <div class="pull-left name-time">
                    <div class="clearfix">
                        <?= Html::a(Helper::truncate_utf8_string(Html::encode($user['username']),4), ['/user/view', 'id' => $user['username'],['style'=>'font-size:15px;']]) ?>&nbsp;•&nbsp;
                        <span class="glyphicon glyphicon-time"></span> <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?>
                    </div>
                </div>
                <br><br>
                <div class="pull-left">
                    <div class="clearfix">
                        <div class="visible-xs visible-sm"><br></div>
                        <span><i class="glyphicon glyphicon-map-marker"></i><?=$profile['address']?></span>&nbsp;&nbsp;
                        <span><i class="glyphicon glyphicon-star"></i>Age&nbsp;&nbsp;<?=floor((time()-strtotime($profile['birthdate']))/(86400*365))?></span>
                        <span>&nbsp;&nbsp;<?=$profile['height']?>cm</span>
                        <span>&nbsp;&nbsp;<?=$profile['weight']?>kg</span>
                    </div>
                    <script>

                        function note(id){


                            var xhr = new XMLHttpRequest();

                            xhr.onreadystatechange = function stateChanged()
                            {
                                if (xhr.readyState==4 || xhr.readyState=="complete")
                                {
                                    $('#follow').html(xhr.responseText);
                                }
                            };

                            xhr.open('get','/index.php/user/user/follow?id='+id);
                            xhr.send(null);
                        }

                    </script>

                    <br>
                    <div class="clearfix"><span>个人标签：</span>
                        <?php
                        if(!empty($profile['mark'])):
                        foreach(json_decode($profile['mark']) as $val):?>
                            <span style="background-color: #FFA02C;color:white;padding:2px 10px;"><?=$val?></span>
                        <?php endforeach;endif;?>
                    </div>
                </div>
            <div class="clearfix"></div>
        </div>
        <br>

        <div style="background-color: white;padding:10px;">
            <article class="thread-main">
                <div class="show-content">
                    <div class="pull-right">
                        <span class="glyphicon glyphicon-comment"></span> <?= $model->post_count ?>
                        <?php if ($user['id'] == Yii::$app->user->id): ?>
                            <a href="<?= Url::toRoute(['/forum/thread/update', 'id' => $model['id']]) ?>">
                                <span class="glyphicon glyphicon-pencil"></span> 更新
                            </a>
                            &nbsp;<a href="<?= Url::toRoute(['/forum/thread/delete', 'id' => $model['id']]) ?>"  data-confirm="确定删除？" data-method="post">
                                <span class="glyphicon glyphicon-trash"></span> 删除
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="clearfix"></div>
                    <div style="padding:10px;text-indent: 35px;"><?=Helper::truncate_utf8_string(HtmlPurifier::process($model->content),2000)?></div>
                </div>
                <div class="row content-img">
                    <div class="col-md-7 col-xs-12 col-sm-9">
                        <?php $m_images = json_decode($model['image_path']);if(!empty($m_images)): for($i=0;$i<count($m_images);$i++):?>
                            <a href="<?=$m_images[$i]?>"  data-lightbox="image-1">
                                <img class="img-thumbnail" src="<?=$m_images[$i]?>">
                            </a>
                        <?php endfor; endif; ?>
                    </div>
                </div>
            </article>
        </div>

        <div class="clearfix"></div>
        <br>
        <div style="background-color: white;padding:10px;">
            <?= $this->render('/post/_form',[
                'model'=>$newPost,
            ]);
            ?>
            <!-- Post Form End -->
            <?= $this->render('_posts', [
                'posts'=>$posts['posts'],
                'pageSize'=>$posts['pages']->pageSize, //分页
                'pages' => $posts['pages'], //分页
                'postCount' => $model->post_count //评论数
            ]);
            ?>

        </div>


    </div>
    <div class="col-md-3 hidden-xs hidden-sm" style="background-color: white;">
        <div style="background-color: white;padding:10px;">

            <?=$this->render('hot-thread',[
                'model' => $model,
                'newPost' => $newPost,
                'hotThread'=>$hotThread,
            ])?>

        </div>
    </div>
</div>



