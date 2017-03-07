<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\myhelper\Helper;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model common\models\User */
$this->registerCssFile('@web/js/lightbox/css/lightbox.css');
$this->registerJsFile(Yii::getAlias('@web')."/js/jquery-1.11.3.js",['position' => View::POS_HEAD]);
$this->registerJsFile('@web/js/lightbox/js/lightbox.min.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);
$user = Yii::$app->user->identity;
$this->title = $model->username;
$this->params['user'] = $model;
$this->params['profile'] = $model->profile;
$this->params['userData'] = $model->userData;
$this->params['thread'] = $model->thread;
$this->registerCss('
 .home-hidden{display:none;}
    .show-hidden{display:none;}
    .hidden-content{display:none;color:black;}
    #top-nav .navbar-toggle.hide-menu{display:none;}
    #main-container{margin-left:0 !important;}
    #top-nav{width:1200px !important;}
    .table-follow span{color:gray;}
    .album-img{width: 120px;height: 130px;}
        .padding-md{padding:0 15px !important;}
    ul{padding:0 !important;margin:0 !important;}
    footer{margin-left:0px;}
    #wrapper.sidebar-mini #main-container{margin-left:0;}
    .post-bg{background-color: white;padding:10px 20px;margin-bottom:15px;}
    .album-img img{height: 130px;}
    @media (max-width:768px){
        .album-img{width: 94px;}

        .content-img img[style*=width][src*=umeditor]{width:65px !important;height:65px !important;}
        #top-nav{width:auto !important;}
        .post-bg{margin-left:0;}
    }


');

?>
<div class="row">

    <div class="col-md-4" style="padding-left: 0;">

        <div style="width: 100%;height: inherit;padding:5px 20px;background-color: white;box-shadow: 0 0 2px #c6c6c6;margin-bottom: 15px;">
            <table class="table text-center table-follow" style="margin-bottom: 0;">
                <tbody>
                <tr>
                    <td style='border: none;'>
                        <a href="/user/dashboard/following">
                            <span class="clearfix">关注</span>
                            <strong><?= $this->params['userData']['following_count'] ?></strong>
                        </a>
                    </td>
                    <td style='border: none;'>
                        <a href="/user/dashboard/follower">
                            <span class="clearfix">粉丝</span>
                            <strong><?= $this->params['userData']['follower_count'] ?></strong>
                        </a>
                    </td>
                    <td style='border: none;cursor: pointer;'>
                        <a>
                            <span class="clearfix">点赞</span>
                            <strong><?=$note_num?></strong>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div style="width: 100%;height: inherit;padding:5px;background-color: white;box-shadow: 0 0 2px #c6c6c6;margin-bottom: 15px;">
            <table class="table text-center" style="margin-bottom: 0;">
                <tbody>
                    <tr style="display:block; margin:5px 0;">
                        <?php for($i=0;$i<$photo_num;$i++):?>
                            <td style='border: none;padding:0 2px;width: 33%;' id="<?= $photos[$i]['id'] ?>">
                                <a href="<?=Yii::getAlias('@web').$photos[$i]['path']?>" data-lightbox="image-1" data-title="<?= Html::encode($photos[$i]['name']) ?>">
                                    <div class="album-img">
                                        <img class="img-thumbnail center-block" src="<?=Yii::getAlias('@web').$photos[$i]['path']?>">
                                    </div>
                                </a>
                            </td>
                        <?php endfor;?>
                    </tr>
                    <tr></tr>
                    <tr style="display:block; margin:10px 0; ">
                        <td style='border: none;padding:0 40px;text-align:left;'>
                            <?php if (!empty($this->params['profile']['address'])): ?>
                                <p class="mb30">
                                    <span class="glyphicon glyphicon-map-marker">&nbsp;</span><?= Html::encode($this->params['profile']['address']) ?>
                                </p>
                            <?php endif ?>

                            <?php if (!empty($this->params['profile']['birthdate'])): ?>
                                <p class="mb30">
                                    <span class="glyphicon glyphicon-star">&nbsp;Age:</span><?= Html::encode(floor((time()-strtotime($this->params['profile']['birthdate']))/(86400*365))) ?>

                                    &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<?= Html::encode($this->params['profile']['height']) ?>cm
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= Html::encode($this->params['profile']['weight']) ?>kg
                                </p>
                            <?php endif ?>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div style="width: 100%;height: inherit;padding:5px;background-color: white;box-shadow: 0 0 2px #c6c6c6;margin-bottom: 15px;">
            <table class="table text-left" style="margin-bottom: 0;">
                <tbody>
                    <tr style="display:block; margin:5px 0; ">
                      <td style="border: none;">我的标签:

                          <?php if (!empty($this->params['profile']['mark'])): ?>
                              <?php $mark = explode(',',$this->params['profile']['mark'])?>
                              <?php for($i=0;$i<count($mark);$i++):?>

                                  <span style="padding: 1px 5px;white-space: nowrap;background-color: #f0ad4e;color: white; line-height: 25px;">   <?=$mark[$i]?></span>

                              <?php endfor;?>
                          <?php endif;?>

                      </td>
                    </tr>

                    <tr style="display:block; margin:10px 0;">
                        <td style="border: none;">交友要求:
                            <?php if (!empty($this->params['profile']['make_friend'])): ?>
                                <?php $friend = explode(',',$this->params['profile']['make_friend'])?>
                                <?php for($i=0;$i<count($friend);$i++):?>

                                    <span style="padding: 1px 5px;white-space: nowrap;background-color: #f04945;color: white; line-height: 25px;">   <?=$friend[$i]?></span>

                                <?php endfor;?>
                            <?php endif;?>

                        </td>
                    </tr>
                    <tr style="display:block; margin:10px 0; ">
                        <td style="border: none;">我的爱好:
                            <?php if (!empty($this->params['profile']['hobby'])): ?>
                                <?php $hobby = explode(',',$this->params['profile']['hobby'])?>
                                <?php for($i=0;$i<count($hobby);$i++):?>

                                    <span style="padding: 1px 5px;white-space: nowrap;background-color: #17f043;color: white; line-height: 25px;">   <?=$hobby[$i]?></span>

                                <?php endfor;?>
                            <?php endif;?>

                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <a href="<?=Url::toRoute('/user/setting')?>">修改个人资料>></a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>
    <div class="col-md-8" style="padding: 0;">
        <?php foreach($this->params['thread'] as $thread):?>

            <div style="width: 100%;height: inherit;padding:15px;margin: 0px;background-color: white;box-shadow: 0 0 2px #c6c6c6;margin-bottom: 10px;">

                <article class="thread-main">
                    <div class="show-content">

                        <?=Helper::truncate_utf8_string(HtmlPurifier::process($thread['content']),70)?>

                    </div>
                    <div class="hidden-content">
                        <?=Helper::truncate_utf8_string(HtmlPurifier::process($thread['content']),5000)?>
                    </div>
                    <?php $content=preg_replace('/<[^>]+>/','',$thread['content']); if(strlen($content)>210):?>

                        <span  style="color:#FF7B4C;cursor: pointer;" onclick="showp(this);">全文缩放</span>
                    <?php endif;?>

                    <div class="row">
                        <div class="col-md-9 col-xs-12 col-sm-9">
                            <?php $m_images = json_decode($thread['image_path']);if(!empty($m_images)):?>
                                <?php for($i=0;$i<count($m_images);$i++):?>
                                    <?php if(count($m_images)==1):?>
                                        <a href="<?=$m_images[$i]?>"  data-lightbox="image-1">
                                            <img class="img-thumbnail" src="<?=$m_images[$i]?>">
                                        </a>
                                    <?php elseif(count($m_images)==2||count($m_images)==4):?>
                                        <a href="<?=$m_images[$i]?>"  data-lightbox="image-1">
                                            <?php if( strpos($m_images[$i],"img.baidu")==false):?>
                                                <img style="width: 50%;height:200px;float: left;" class="img-thumbnail" src="<?=$m_images[$i]?>">
                                            <?php else:?>
                                                <img class="img-thumbnail" src="<?=$m_images[$i]?>">
                                            <?php endif;?>
                                        </a>
                                    <?php elseif(count($m_images)==3||count($m_images)==9||count($m_images)==5||count($m_images)==6):?>
                                        <a href="<?=$m_images[$i]?>"  data-lightbox="image-1">
                                            <?php if( strpos($m_images[$i],"img.baidu")==false):?>
                                                <img style="width: 33%;height:140px;float: left;" class="img-thumbnail" src="<?=$m_images[$i]?>">
                                            <?php else:?>
                                                <img class="img-thumbnail" src="<?=$m_images[$i]?>">
                                            <?php endif;?>
                                        </a>
                                    <?php elseif(count($m_images)==7||count($m_images)==8):?>
                                        <a href="<?=$m_images[$i]?>"  data-lightbox="image-1">
                                            <?php if( strpos($m_images[$i],"img.baidu")==false):?>
                                                <img style="width: 25%;height:100px;float: left;" class="img-thumbnail" src="<?=$m_images[$i]?>">
                                            <?php else:?>
                                                <img class="img-thumbnail" src="<?=$m_images[$i]?>">
                                            <?php endif;?>
                                        </a>
                                    <?php endif;endfor;?>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>

            <script>
                function showp(content){

                    var context = $(content);
                    context.siblings('.show-content').toggle();
                    context.siblings('.hidden-content').toggle();

                }
                function read(id){
                    var xhr = new XMLHttpRequest();
                    xhr.open('get','/index.php/forum/thread/read?id='+id);
                    xhr.send(null);
                }
                function note(id){
                    var xhr = new XMLHttpRequest();
                    xhr.open('get','/index.php/forum/thread/note?id='+id);
                    xhr.send(null);
                }

            </script>
            <div class="clearfix"></div>
            <small>

                <time title="<?= Yii::t('app', 'Last Reply Time') ?>">
                    <span class="glyphicon glyphicon-time"></span> <?= Yii::$app->formatter->asRelativeTime($thread['updated_at'])?>
                </time>
            </small>
            <div class="clearfix"></div>
                <hr style="margin-bottom: 5px;">
                <div class="note-a">
                    <?= Html::a('阅读' . $thread['read_count'],'#',['title'=>'阅读']); ?>&nbsp;
                    <span class="line-note"></span>
                    &nbsp;&nbsp;<a style="cursor: pointer;" title="回复" onclick="reply(<?=$thread['id']?>,this);post(<?=$thread['id']?>,this);clear_list(this);">评论<?=$thread['post_count']?></a>&nbsp;
                    <span class="line-note"></span>
                    &nbsp;&nbsp;<a onclick="notes(<?=$thread['id']?>,this)" title="点赞" style="cursor: pointer;" id="click-note">喜欢<?=$thread['note']?></a>
                    <div style="margin-bottom: 10px;"></div>
                    <div class="show_reply clearfix" style="display: none;"></div>
                    <div class="show_post clearfix" style="display: none;"></div>
                </div>
            </div>


        <?php endforeach;?>


    </div>

</div>