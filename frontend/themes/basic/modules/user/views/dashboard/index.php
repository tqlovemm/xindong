<?php

use yii\helpers\Html;
use yii\myhelper\Helper;
use yii\helpers\HtmlPurifier;

$this->registerCssFile('@web/js/lightbox/css/lightbox.css');
$this->registerJsFile('@web/js/lightbox/js/lightbox.min.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);

$userData = Yii::$app->userData->getKey(true);
$userProfile = Yii::$app->userProfile->getKey(true);
/* @var $this yii\web\View */
$user = Yii::$app->user->identity;
$this->title=Yii::$app->user->identity->username.' - '.Yii::t('app', 'Home');

$this->registerCss('

    .home-hidden{display:none;}
    #top-nav .navbar-toggle.hide-menu{display:none;}
    #main-container{margin-left:0 !important;}
    #top-nav{width:1200px !important;}
    .padding-md{padding:0 15px !important;}
    ul{padding:0 !important;margin:0 !important;}
    footer{margin-left:0px;}
    #wrapper.sidebar-mini #main-container{margin-left:0;}
    .post-bg{background-color: white;padding:10px 20px;margin-bottom:15px;}
    @media (max-width:768px){



       #top-nav{width:auto !important;}
       .post-bg{margin-left:0;}
}

');
?>

<div class="item widget-container share-widget fluid-height clearfix">

    <div class="row" style="padding: 5px 0;">

        <div class="col-md-3" style="padding:0;">
            <ul class="list-group list-inline list-unstyled">
                <li class="text-center" style="width: 32%">
                    <span class="clearfix">关注</span>
                    <span><?=$userData['following_count']?></span>
                </li>
                <li class="text-center" style="width: 32%">
                    <span class="clearfix">粉丝</span>
                    <span><?=$userData['follower_count']?></span></li>
                <li class="text-center" style="width: 32%">
                    <span class="clearfix">点赞</span>
                    <span><?=$note_sum?></span></li>

            </ul>
        </div>
        <div class="col-md-9" >

            <?=Html::a('我的相册','/index.php/home/album',['class'=>'list-group-item pull-left','style'=>'border:none;background:none;'])?>
            <?=Html::a('私密日志','/index.php/home/post',['class'=>'list-group-item pull-left','style'=>'border:none;background:none;'])?>
        </div>
    </div>
    <div class="row" style="margin:0 -15px; background-color: #dcdcdc;padding:15px 0px 10px 0px;">

        <div class="col-md-3" style="background-color: whitesmoke;padding:0px;margin-bottom: 20px;">

            <?php for($i=0;$i<=$photo_num;$i++): if(!empty($photo[$i])):?>
                <a href="<?=Yii::getAlias('@web').$photo[$i]['path']?>"  data-lightbox="image-1">
                    <div style="background: url('<?=Yii::getAlias('@web').$photo[$i]['path']?>') center;width: 90px;height: 80px;float: left;margin: 5px;"></div>
                </a>
            <?php endif;endfor; ?>

            <div class="clearfix"></div>
            <ul class="list-group list-unstyled">
                <li class="list-group-item" style="padding-left:40px;border:none;">
                    <span class="glyphicon glyphicon-map-marker"></span>&nbsp;&nbsp;&nbsp;<span><?=$userProfile['address']?></span>
                </li>
                <li class="list-group-item" style="padding-left:40px;border:none;">
                    <span class="glyphicon glyphicon-star"></span>&nbsp;&nbsp;&nbsp;<span>Age:<?=floor((time()-strtotime($userProfile['birthdate']))/(86400*365))?></span>
                    <span class="clearfix">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$userProfile['height']?>cm &nbsp;&nbsp;&nbsp; <?=$userProfile['weight']?>kg</span>
                </li>
                <li class="list-group-item" style="padding-left:40px;border:none;">
                    <span>我的标签：</span>

                    <?php
                    if(!empty(json_decode($userProfile['mark']))):
                    foreach(json_decode($userProfile['mark']) as $mark):?>

                        <span style="background-color: darkorange;padding:0 2px;color:whitesmoke;margin-left:2px;white-space: nowrap;">
                            <?=$mark?>
                        </span>

                    <?php
                    endforeach;
                    endif;
                    ?>

                </li>

                <li class="list-group-item text-center">

                    <a class="clearfix" href="/index.php/user/setting">编辑个人资料</a>

                </li>

            </ul>
            <div style="height: 15px;width: 100%;background-color: #dcdcdc;"></div>

            <?php if(Yii::$app->user->identity->sex==0){?>
            <li class="list-group-item">我的抢福利</li>
            <ul class="list-group list-inline text-center">

                <li class="list-group-item" style="width: 32%;overflow: hidden;white-space: nowrap;border: none;">
                    <img src="<?=$user->avatar?>" width="80"><br>
                    <span><?=$user->username?></span><br>
                    <span>体重：</span><br>
                    <span>身高：</span><br>
                </li>
                <li class="list-group-item" style="width: 32%;overflow: hidden;white-space: nowrap;border: none;">
                    <img src="<?=$user->avatar?>" width="80"><br>
                    <span><?=$user->username?></span><br>
                    <span>体重：</span><br>
                    <span>身高：</span><br>
                </li>
                <li class="list-group-item" style="width: 32%;overflow: hidden;white-space: nowrap;border: none;">
                    <img src="<?=$user->avatar?>" width="80"><br>
                    <span><?=$user->username?></span><br>
                    <span>体重：</span><br>
                    <span>身高：</span><br>
                </li>

            </ul>
            <?php }else{?>

                <li class="list-group-item">我的翻牌</li>
                <ul class="list-group list-inline text-center">

                    <li class="list-group-item" style="width: 32%;overflow: hidden;white-space: nowrap;border: none;">
                        <img src="<?=$user->avatar?>" width="80"><br>
                        <span><?=$user->username?></span><br>
                        <span>体重：</span><br>
                        <span>身高：</span><br>
                    </li>
                    <li class="list-group-item" style="width: 32%;overflow: hidden;white-space: nowrap;border: none;">
                        <img src="<?=$user->avatar?>" width="80"><br>
                        <span><?=$user->username?></span><br>
                        <span>体重：</span><br>
                        <span>身高：</span><br>
                    </li>
                    <li class="list-group-item" style="width: 32%;overflow: hidden;white-space: nowrap;border: none;">
                        <img src="<?=$user->avatar?>" width="80"><br>
                        <span><?=$user->username?></span><br>
                        <span>体重：</span><br>
                        <span>身高：</span><br>
                    </li>

                </ul>

            <?php }?>
        </div>

        <div class="col-md-9">

            <?php foreach($model as $thread): ?>
                <div class="post-bg" style="margin-bottom:20px;">
                  <div class="clearfix"></div>
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tbody>
                        <tr>

                                <?php

                                $preg = "/[\x{4e00}-\x{9fa5}]+/u";
                                preg_match_all($preg,HtmlPurifier::process($thread['content']),$matches);

                                $strlen_content = strlen(serialize($matches[0]));

                                ?>
                            <a href="/index.php/thread/<?=$thread['id']?>" style="color:gray;">
                                <article class="thread-main">

                                    <div><?=Helper::truncate_utf8_string(HtmlPurifier::process($thread['content']),80)?></div>


                                    <div class="clearfix"></div>

                                    <?php
                                    $preg = "/<img src=\"(.+?)\".*?>/";

                                    preg_match_all($preg,HtmlPurifier::process($thread['content']),$new_cnt);

                                    foreach($new_cnt[0] as $images){

                                        $pattern ='<img.*?src="(.*?)">';
                                        preg_match($pattern,$images,$matches);

                                        ?>

                                        <div style='width: 100px;height: 80px;margin: 10px 10px 10px 0;float: left;background: url("<?=$matches[1]?>") no-repeat center;'></div>

                                        <?php
                                    }

                                    ?>
                                </article>
                                </a>

                                <div class="clearfix"></div>
                                <?=date('Y-m-d',$thread['created_at'])?><br><br>
                                <?= Html::a('阅读' . $thread['read_count'],'#',['title'=>'阅读','style'=>'color:gray;']); ?>&nbsp;&nbsp;
                                <?= Html::a('评论 ' . $thread['post_count'], ['/forum/thread/view', 'id' => $thread['id']], ['title'=>'回复','style'=>'color:gray;']); ?>
                                &nbsp;&nbsp;<?= Html::a('喜欢' . $thread['note'], '#', ['title'=>'点赞','style'=>'color:gray;']); ?>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</div>

