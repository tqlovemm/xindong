<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\myhelper\Helper;
use yii\helpers\HtmlPurifier;
use app\modules\user\models\User;
use yii\widgets\LinkPager;
use app\modules\forum\models\Thread;
use yii\web\View;
use app\themes\basic\modules\forum\AppAsset2;
AppAsset2::register($this);
$userProfile = Yii::$app->userProfile->getKey(true);

$this->registerCss('
    .padding-md{padding:20px 0 !important;}
    .forum-avatar{width:100px;}
    .show-hidden{display:none;}
    .hidden-content{display:none;color:black;}
    .show-content>a{color:black;}
    .show-content,.hidden-content{word-break:break-all;}
    .badge{background-color: #777;color: #fff;}
    .threads_content{padding:5px;margin-left: -20px;}


    .show_reply,.show_post{background-color:#F2F2F5;margin-left:-120px;margin-right:-10px;padding:0 10px;}
    .show_post post-list{padding:5px;width:100%;min-height:200px;border-bottom:1px solid #D9D9D9;background-color:#F2F2F5;margin:0;}
    .show_post p{margin:0;float:left;word-break:break-all}
    .show_post span{margin:0;float:left;}
    .show_info{ width: 300px;height: auto;
                display: none;background-color: grey;
                position: absolute;left:80px;top:-80px;
                box-shadow:0 0 5px #999;
                background:white;
                z-index:9;}

    .forum-img:hover .show-info{display:block;}

     @media (max-width: 768px) {
        .content-img img[style*=width][src*=umeditor]{width:65px !important;height:65px !important;}
        .show_info{left:40px;width: 250px;}
        .show-hidden{display:block;}
        .thread-main img{float:left;margin:1px;}
        .container-fluid{padding:0;}
        .forum-title{font-size:20px;}
        .forum-img{width:40px;}
        .forum-avatar{width:40px;}
        p{line-height:20px;}
        .hidden{display:none !important;}
        .threads_content{margin: auto;}
        .show_reply,.show_post{background-color:#F2F2F5;margin-left:-60px;padding:0 10px;}
    }
    .sort-check a{border-radius:30%;background:none;border:1px solid #cecece;color:black;padding:3px 10px;}
    .sort-checked a{background-color:#E7826B;color:white;}
');
?>
<?php
$this->registerJsFile('@web/js/lightbox/js/lightbox.min.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);
$this->registerCssFile('@web/js/lightbox/css/lightbox.css');
?>
<ul class="list-inline" style="color: #cecece;">
    <li class="sort-check <?php if($_SERVER["QUERY_STRING"]=='sort=-t.created_at'||$_SERVER["QUERY_STRING"]=='sort=t.created_at'){echo 'sort-checked';}?>"><?=$sort->link('t.created_at')?></li>
    <li class="sort-check <?php if($_SERVER["QUERY_STRING"]=='sort=-t.read_count'||$_SERVER["QUERY_STRING"]=='sort=t.read_count'){echo 'sort-checked';}?>"><?=$sort->link('t.read_count')?></li>
    <li class="sort-check <?php if($_SERVER["QUERY_STRING"]=='sort=following'){echo 'sort-checked';}?>"><a href="<?=Url::toRoute(['/forums','sort'=>'following'])?>">关注</a></li>
</ul>
<div class="threads threads_content" id="content">
<!--置顶贴-->
    <?php if(!empty($stick)):
        foreach($stick as $thread):
    ?>
            <article class="thread-item" style="margin-bottom:10px;background-color: white;box-shadow: 0 0 5px #cacaca;padding:10px;">
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tbody>
                    <tr>
                        <td class="forum-avatar" valign="top" align="center" style="position: relative;">

                            <?php if($thread['username']!=Yii::$app->user->identity->username){?>
                            <div style="cursor: pointer;" onmouseenter="show_info(this)" onmouseleave="hidden_info(this)">
                                <?php }else{ ?>
                                <div style="cursor: pointer;">
                                    <?php }?>
                                    <a href="<?= Url::toRoute(['/user/view', 'id' => $thread['username']])?>"><img class="media-object img-user-avatar img-responsive forum-img img-circle" src="<?= $thread['avatar'] ?>" alt="十三平台" width="60"></a>
                                    <div class="show_info">

                                        <div style="width: 100%;height: 45%;background-color: #e0ddd6;" class="clearfix">
                                            <img class="img-circle" src="<?= $thread['avatar'] ?>" width="20%">
                                            <div style="color:#161616;font-size: 18px;"><?=$thread['username']?></div>
                                            <div style="font-size: 14px;width: 100%;white-space: nowrap;overflow: hidden;color:#4b4b4b;"><?=$thread['description']?></div>
                                        </div>
                                        <div style="width: 100%;height: 55%;color:#292929;background-color: white;padding:5px;" class="clearfix">
                                            <span class="glyphicon glyphicon-map-marker"><?=$thread['address']?></span>&nbsp;&nbsp;&nbsp;
                                            <span class="glyphicon glyphicon-star"></span>&nbsp;<span>Age:<?=floor((time()-strtotime($thread['birthdate']))/(86400*365))?></span>
                                            <span>&nbsp;&nbsp;&nbsp;&nbsp;<?=$thread['height']?>cm &nbsp;&nbsp;&nbsp; <?=$thread['weight']?>kg</span>

                                            <div class="clearfix" style="margin: 5px;"></div>
                                            <a onclick="note(<?=$thread['user_id']?>,this)" class="btn btn-default" style="padding:1px 15px;"><i class="glyphicon glyphicon-plus text-danger"></i>
                                                <?php if(User::getIsFollow($thread['user_id'])){echo '已关注';}else{echo '关注';}?></a>
                                            </a>
                                            <a class="btn btn-default"  href="<?= Url::toRoute(['/user/view', 'id' => $thread['username']])?>" style="padding:1px 15px;">进入主页</a>

                                            <div class="clearfix" style="margin: 5px;"></div>
                                            <div class="text-left" style="padding:0 20px;">

                                                <div class="hidden-xs">
                                                    <span>我的标签:</span>

                                                    <?php $mark_num = count(json_decode($thread['mark']))>8?8:count(json_decode($thread['mark']));
                                                    for($i=0;$i<$mark_num;$i++){?>
                                                        <span id="all_data" style="background-color: darkorange;padding:0 2px;color:whitesmoke;margin-left:2px;white-space: nowrap;">
                                                    <?=json_decode($thread['mark'])[$i]?>
                                                </span>

                                                    <?php }?>
                                                </div>
                                                <div class="clearfix"></div>
                                                <span>交友要求:</span>

                                                <?php $make_friend_num = count(json_decode($thread['make_friend']))>8?8:count(json_decode($thread['make_friend']));
                                                for($i=0;$i<$make_friend_num;$i++){?>
                                                    <span id="all_data" style="background-color: #ff2725;padding:0 2px;color:whitesmoke;margin-left:2px;white-space: nowrap;">
                                                    <?=json_decode($thread['make_friend'])[$i]?>
                                                </span>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </td>
                        <td width="10"></td>
                        <td width="auto" class="content-img" style="position: relative;">
                            <small>
                                <strong>
                                    <?php if(!empty($thread['nickname'])){
                                        echo Html::a(Html::encode($thread['nickname']), ['/user/view', 'id'=>$thread['username']], ['class'=>'thread-nickname','style'=>'color:#0047B1;font-size:16px;']);
                                    }else{
                                        echo Html::a(Html::encode($thread['username']), ['/user/view', 'id'=>$thread['username']], ['class'=>'thread-nickname','style'=>'color:#0047B1;font-size:16px;']);
                                    }?>
                                </strong>
                                &nbsp;•&nbsp;
                                <time title="<?= Yii::t('app', 'Last Reply Time') ?>">
                                    <span class="glyphicon glyphicon-time"></span> <?= Yii::$app->formatter->asRelativeTime($thread['created_at'])?>
                                </time>
                                <!--功能块-->
                            <span class="pull-right dropdown">
                                 <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                     <span class="glyphicon glyphicon-chevron-down btn btn-default btn-xs" style="padding:0 10px;color:orangered"></span>
                                 </a>
                                 <ul class="dropdown-menu">
                                     <?php if(Yii::$app->user->id==10000):?>
                                         <li><a onclick="stick(<?=$thread['id']?>)" title="stick">
                                                 <?php $model = new Thread();if($model->isStick($thread['id'])['is_stick']==1){echo '取消置顶';}else{echo '置顶';} ?>
                                             </a></li>

                                     <?php endif;?>
                                     <?php if(in_array(Yii::$app->user->id,[$thread['user_id'],10000])):?>
                                         <li><a href="<?=Url::toRoute(['/forum/thread/update','id'=>$thread['id']])?>">更新</a></li>
                                         <li><a href="<?=Url::toRoute(['/forum/thread/delete','id'=>$thread['id']])?>" data-confirm="确认删除吗？" data-method="post">删除</a></li>
                                         <?php else:?>
                                         <li><a onclick="window.open('/index.php/user/user-claims?id='+<?=$thread['id']?>,'弹出窗口','width=400,height=500,top=0,left=0')" target="_blank">举报</a></li>
                                     <?php endif;?>
                                 </ul>
                            </span>
                            </small>

                            <article class="thread-main">

                                <div class="show-content">

                                        <span style="background-color: #ea0f1f;padding: 1px 3px;color:white;border-radius: 2px;"><i class="glyphicon glyphicon-pushpin"></i>&nbsp;置顶</span>

                                        &nbsp;&nbsp;<?=Helper::truncate_utf8_string(HtmlPurifier::process($thread['content']),70)?>


                                </div>
                                <div class="hidden-content">
                                    <span style="background-color: #ea0f1f;padding: 1px 3px;color:white;border-radius: 2px;"><i class="glyphicon glyphicon-pushpin"></i>&nbsp;置顶</span>

                                    &nbsp;&nbsp;<?=Helper::truncate_utf8_string(HtmlPurifier::process($thread['content']),5000)?>
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
                        </td>
                    </tr>
                    </tbody>
                </table>
            </article>
    <?php
        endforeach;
    endif;
    ?>
<!--非置顶贴-->
    <?php foreach($threads as $thread): ?>
        <article class="thread-item" style="margin-bottom:10px;background-color: white;box-shadow: 0 0 5px #cacaca;padding:10px;">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tbody>
                <tr>
                    <td class="forum-avatar" valign="top" align="center" style="position: relative;">

                        <?php if($thread['username']!=Yii::$app->user->identity->username){?>
                        <div style="cursor: pointer;" onmouseenter="show_info(this)" onmouseleave="hidden_info(this)">
                            <?php }else{ ?>
                            <div style="cursor: pointer;">
                                <?php }?>
                                <a href="<?= Url::toRoute(['/user/view', 'id' => $thread['username']])?>"><img class="media-object img-user-avatar img-responsive forum-img img-circle" src="<?= $thread['avatar'] ?>" alt="十三平台" width="60"></a>
                                <div class="show_info">

                                    <div style="width: 100%;height: 45%;background-color: #e0ddd6;" class="clearfix">
                                        <img class="img-circle" src="<?= $thread['avatar'] ?>" width="20%">
                                        <div style="color:#161616;font-size: 18px;"><?=$thread['username']?></div>
                                        <div style="font-size: 14px;width: 100%;white-space: nowrap;overflow: hidden;color:#4b4b4b;"><?=$thread['description']?></div>
                                    </div>
                                    <div style="width: 100%;height: 55%;color:#292929;background-color: white;padding:5px;" class="clearfix">
                                        <span class="glyphicon glyphicon-map-marker"><?=$thread['address']?></span>&nbsp;&nbsp;&nbsp;
                                        <span class="glyphicon glyphicon-star"></span>&nbsp;<span>Age:<?=floor((time()-strtotime($thread['birthdate']))/(86400*365))?></span>
                                        <span>&nbsp;&nbsp;&nbsp;&nbsp;<?=$thread['height']?>cm &nbsp;&nbsp;&nbsp; <?=$thread['weight']?>kg</span>

                                        <div class="clearfix" style="margin: 5px;"></div>
                                        <a onclick="note(<?=$thread['user_id']?>,this)" class="btn btn-default" style="padding:1px 15px;"><i class="glyphicon glyphicon-plus text-danger"></i>
                                            <?php if(User::getIsFollow($thread['user_id'])){echo '已关注';}else{echo '关注';}?></a>
                                        </a>
                                        <a class="btn btn-default"  href="<?= Url::toRoute(['/user/view', 'id' => $thread['username']])?>" style="padding:1px 15px;">进入主页</a>

                                        <div class="clearfix" style="margin: 5px;"></div>
                                        <div class="text-left" style="padding:0 20px;">

                                            <div class="hidden-xs">
                                                <span>我的标签:</span>

                                                <?php $mark_num = count(json_decode($thread['mark']))>8?8:count(json_decode($thread['mark']));
                                                for($i=0;$i<$mark_num;$i++){?>
                                                    <span id="all_data" style="background-color: darkorange;padding:0 2px;color:whitesmoke;margin-left:2px;white-space: nowrap;">
                                                    <?=json_decode($thread['mark'])[$i]?>
                                                </span>

                                                <?php }?>
                                            </div>
                                            <div class="clearfix"></div>
                                            <span>交友要求:</span>

                                            <?php $make_friend_num = count(json_decode($thread['make_friend']))>8?8:count(json_decode($thread['make_friend']));
                                            for($i=0;$i<$make_friend_num;$i++){?>
                                                <span id="all_data" style="background-color: #ff2725;padding:0 2px;color:whitesmoke;margin-left:2px;white-space: nowrap;">
                                                    <?=json_decode($thread['make_friend'])[$i]?>
                                                </span>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </td>
                    <td width="10"></td>
                    <td width="auto" class="content-img" style="position: relative;">
                        <small>
                            <strong>
                                <?php if(!empty($thread['nickname'])){
                                    echo Html::a(Html::encode($thread['nickname']), ['/user/view', 'id'=>$thread['username']], ['class'=>'thread-nickname','style'=>'color:#0047B1;font-size:16px;']);
                                }else{
                                    echo Html::a(Html::encode($thread['username']), ['/user/view', 'id'=>$thread['username']], ['class'=>'thread-nickname','style'=>'color:#0047B1;font-size:16px;']);
                                }?>
                            </strong>
                            &nbsp;•&nbsp;
                            <time title="<?= Yii::t('app', 'Last Reply Time') ?>">
                                <span class="glyphicon glyphicon-time"></span> <?= Yii::$app->formatter->asRelativeTime($thread['created_at'])?>
                            </time>
                            <!--功能块-->
                            <span class="pull-right dropdown">
                                 <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                     <span class="glyphicon glyphicon-chevron-down btn btn-default btn-xs" style="padding:0 10px;color:orangered"></span>
                                 </a>
                                 <ul class="dropdown-menu">
                                     <?php if(Yii::$app->user->identity->groupid==0):?>
                                         <li><a onclick="stick(<?=$thread['id']?>)" title="stick">
                                                 <?php $model = new Thread();if($model->isStick($thread['id'])['is_stick']==1){echo '取消置顶';}else{echo '置顶';} ?>
                                             </a></li>
                                     <?php endif;?>

                                     <?php if(Yii::$app->user->id==$thread['user_id']||Yii::$app->user->identity->groupid==0):?>
                                         <li><a href="<?=Url::toRoute(['/forum/thread/update','id'=>$thread['id']])?>">更新</a></li>
                                         <li><a href="<?=Url::toRoute(['/forum/thread/delete','id'=>$thread['id']])?>" data-confirm="确认删除吗？" data-method="post">删除</a></li>
                                     <?php else:?>
                                         <li><a onclick="window.open('/index.php/user/user-claims?id='+<?=$thread['id']?>,'弹出窗口','width=400,height=500,top=0,left=0')" target="_blank">举报</a></li>
                                     <?php endif;?>
                                 </ul>
                            </span>
                        </small>

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
                    </td>
                </tr>
                </tbody>
            </table>
        </article>
    <?php endforeach;?>
    <div class="text-center"> <?=LinkPager::widget(['pagination' => $thread_pages,])?></div>
</div>

<script>
    window.onload = function(){
        var xhr = new XMLHttpRequest();
        xhr.open('get','/index.php/forum/thread/read');
        xhr.send(null);
    };
</script>



