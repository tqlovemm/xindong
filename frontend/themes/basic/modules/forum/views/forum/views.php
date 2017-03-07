<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\user\models\User;
use app\modules\home\models\Sigin;

$userData = Yii::$app->userData->getKey(true);
$sigin = Yii::$app->sigin->getKey(true);

$this->title='男女发帖';
$this->params['breadcrumbs'][] = ['label' => '论坛', 'url' => ['views?sort=-t.created_at']];
$this->params['breadcrumbs'][] = $this->title;
$user = Yii::$app->user->identity;

$this->registerCss('

    .job-success i,.job-success a,.job-success span{color:gray;}
    .liablock a,.liablock strong,.liablock span{display:block;line-height:18px;width:100%;}
    .liablock span{color:gray;}
    .liablock li{width:55px;}
    .btn-position{right:30%;bottom:84%;font-size:15px;}
    .table-nob>tbody>tr>td{border:none;}
    .table-nob>tbody>tr>td>a>span{color:gray;}
    .btn-red{background: rgba(198, 81, 81,1);}
    .edui-body-container img{width:100px;height:100px;float:left;}
    .edui-body-container p:nth-last-child(1){clear:both;}
     @media (max-width: 768px) {
            .btn-position{right:0px;bottom:10%;font-size:15px;}
            #edui-dialog-image{width:300px !important;}
            .edui-dialog-image-body{width:300px !important;height:300px !important;}
            .edui-dialog-image .edui-image-content{height:200px !important;}
            .edui-dropdown-menu{width:300px !important;left:-20px !important;}
     }

');
?>

<button class="btn btn-red btn-position" style="width: 60px !important;position: fixed;z-index: 9;;padding:2px 10px;color:#cac7be;" data-toggle="modal" data-target="#myModal">发帖</button>

<div class="col-xs-12 col-sm-12 col-md-9">
    <div class="widget-container" style="position: relative;">
        <?php if(!empty($following)){
            echo $this->render('_threads', [
                'threads2'=>$thread2,
                'thread2_pages'=>$thread2_pages,
                'sort'=>$sort,
            ]);

        }else{
            echo $this->render('_threads2', [
                'threads'=>$thread,
                'thread_pages'=>$thread_pages,
                'sort'=>$sort,
                'stick'=>$stick,

            ]);
        }
        ?>
    </div>
</div>
<div class="col-md-3 hidden-xs">

    <div style="width: 100%;height:230px;margin: auto;margin-bottom: 10px;">

        <div style="height: 100%;width: 100%;background: white;padding:10px 10px 5px 10px;position: relative;">

            <a href="<?= Url::toRoute(['/user/setting'])?>"><img class="img-responsive img-circle" style="width: 70px;height: 70px;margin: auto;" src="<?=  $user->avatar ?>"></a>

            <div style="height: 16px;line-height: 16px;padding-top: 5px;text-align: center;color:black;">

                <?php if(!empty($user->nickname)){
                    echo Html::a(\yii\myhelper\Helper::truncate_utf8_string($user->nickname,5),'/',['style'=>'color:#333;font-size:16px;font-weight:bold;']);
                }else{
                    echo Html::a(\yii\myhelper\Helper::truncate_utf8_string($user->username,5),'/',['style'=>'color:#333;font-size:16px;font-weight:bold;']);
                }?>

                &nbsp;
                <?=Html::a('<span class="glyphicon glyphicon-tower"></span>','/',['style'=>'color:gray;'])?>
                &nbsp;

                <?=Html::a('Lv'.$level,'/',['style'=>'border-radius:8px;background:#ffb400;padding:.5px 5px;color:white;'])?>
            </div>

            <div style="margin-top:10px;text-align: center;">
                <table class="table table-nob">
                    <tbody>
                        <tr>
                            <td><a href="/user/dashboard/following"><strong class="clearfix"><?=$userData['following_count']?></strong><span>关注</span></a></td>
                            <td><a  href="/user/dashboard/follower"><strong class="clearfix"><?= $userData['follower_count'] ?></strong><span>粉丝</span></a></td>
                            <td><a href="/u/<?=Yii::$app->user->identity->username?> "><strong class="clearfix"><?= $userData['thread_count'] ?></strong><span>发帖</span></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        <div class="text-center">

            <?php if(Sigin::getIsSign()):?>
                <span><a class="btn btn-success btn-sm disabled">今日已签到</a></span>
            <?php else:?>
                <span id="isSign">
                    <a class="btn btn-success btn-sm" onclick="sigin();">签到打卡</a>
                </span>
            <?php endif;?>
                <span class="btn text-danger" style="padding:4px 0;" data-toggle="modal" data-target="#jiecaobi">
                    节操币：<i class="glyphicon glyphicon-usd"></i><i id="feed_data"><?= $sigin['sigindata'] ?></i>
                </span>
        </div>
        </div>
    </div>

    <div class="user-block clearfix text-center">

        <div class="modal fade" id="jiecaobi" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            节操币简介
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item list-group-item-success">节操币获取方式</li>
                                    <li class="list-group-item">签到打卡</li>
                                    <li class="list-group-item">关注好友</li>
                                    <li class="list-group-item">女生发帖</li>
                                    <li class="list-group-item">评论贴子</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item list-group-item-danger">节操币消费方式</li>
                                    <li class="list-group-item">男生发帖</li>
                                    <li class="list-group-item">男生报名抢福利</li>
                                    <li class="list-group-item">女生翻牌</li>
                                    <li class="list-group-item">取消关注好友</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">关闭
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
    <script>
        function sigin(){

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function stateChanged()
            {
                if (xhr.readyState==4 || xhr.readyState=="complete")
                {
                    document.getElementById("feed_data").innerHTML=xhr.responseText;
                    document.getElementById("isSign").innerHTML = '<a class="btn btn-success btn-sm disabled">今日已签到</a>';
                }
            };

            xhr.open('get','/index.php/home/feed');

            xhr.send(null);
        }
        function showp(content){

            var context = $(content);
            context.siblings('.show-content').toggle();
            context.siblings('.hidden-content').toggle();

        }
    </script>

    <div class="panel text-left">
        <div class="panel-heading">
            <h3 class="panel-title">任务领节操币</h3>
        </div>
        <div class="panel-body">
            <ul class="list-unstyled ">
                <li class="list-group-item clearfix job-success" style="border: none;">
                    <i class="glyphicon glyphicon-check pull-left">&nbsp;</i>
                    <a class="pull-left" href="#">女生发帖</a>
                    <span class="pull-right">+2<i class="glyphicon  glyphicon-heart"></i></span>
                </li>
                <li class="list-group-item clearfix job-success" style="border: none;">
                    <i class="glyphicon  glyphicon-unchecked pull-left">&nbsp;</i>
                    <a class="pull-left" href="#">关注好友</a>
                    <span class="pull-right">+1<i class="glyphicon  glyphicon-heart"></i></span>
                </li>
                <li class="list-group-item clearfix job-success" style="border: none;">
                    <i class="glyphicon glyphicon-unchecked pull-left">&nbsp;</i>
                    <a class="pull-left" href="#">热贴评论</a>
                    <span class="pull-right">+1<i class="glyphicon  glyphicon-heart"></i></span>
                </li>
            </ul>
        </div>
    </div>

    <div class="panel text-left">
        <div class="panel-heading"><h3 class="panel-title" style="color:rgba(198, 81, 81,1);border-left: 2px solid rgba(198, 81, 81,1);">&nbsp;&nbsp;最近活动报名</h3></div>
        <div class="panel-body">

            <img src="<?=Yii::getAlias('@web')?>/images/girl.jpg" width="100%">

        </div>
    </div>

        <div class="panel text-left">
        <div class="panel-heading">
            <h3 class="panel-title">活跃用户</h3>
        </div>
        <div class="panel-body">
            <ul class="list-inline">
                <?php $users = new User();for($i=0;$i<6;$i++){$val = $pages[$i]['user_id'] ?>
                    <li style="margin:5px 0;padding:0;width: 30%" class="text-center">
                        <a href="/u/<?=$users->getInfo($val)['username']?>">
                        <img src="<?= $users->getInfo($val)['avatar'] ?>" width="70%">
                        <h4 style="color: #0047B1;margin-bottom:0;white-space:nowrap;margin-top: 5px;font-size: 13px;overflow: hidden;">
                            <?php if(!empty($users->getInfo($val)['nickname'])){
                                echo \yii\myhelper\Helper::truncate_utf8_string($users->getInfo($val)['nickname'],4);
                            }else{
                                echo \yii\myhelper\Helper::truncate_utf8_string($users->getInfo($val)['username'],4);}?>
                           </h4>
                        <span style="font-size: 12px;"></span>&nbsp;
                        </a>
                        <a style="cursor: pointer;" class="note_small" onclick="return note(<?=$val?>,this)">
                           <?php if(User::getIsFollow($val)){echo '取消';}else{echo '关注';}?>
                        </a>

                    </li>

                <?php }?>


                <script>

                    function note(id,content){

                        var con= $(content);
                        var xhr = new XMLHttpRequest();

                        xhr.onreadystatechange = function stateChanged()
                        {
                            if (xhr.readyState==4 || xhr.readyState=="complete")
                            {
                                con.html(xhr.responseText);
                            }
                        };
                        xhr.open('get','/index.php/user/user/follow?id='+id);
                        xhr.send(null);
                    }
                </script>
            </ul>
        </div>
        </div>
    </div>



