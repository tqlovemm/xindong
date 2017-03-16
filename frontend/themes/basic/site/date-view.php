<?php

\frontend\assets\AutoAsset::register($this);
$this->title = $area['title'].'妹子';

$plate = '';
if(!empty($contents['title'])){
    $plate .= $contents['title'];
}
if(!empty($contents['title2'])){
    $plate .= '&'.$contents['title2'];
}
if(!empty($contents['title3'])){
    $plate .= '&'.$contents['title3'];
}

$area_china = array(
    '美国','英国','荷兰','加拿大','比利时','澳洲','德国','法国','新西兰','马来西亚','西班牙','意大利','泰国','韩国','新加坡'
);
$addresses = array();
if(!Yii::$app->user->isGuest){

    $user_id = Yii::$app->user->id;
    $groupid = Yii::$app->user->identity->groupid;

    $address = Yii::$app->db->createCommand("select address_1,address_2,address_3 from {{%user_profile}} where user_id=$user_id")->queryOne();

    if(!empty($address['address_1'])){

        $address_1 = array_values(json_decode($address['address_1'],true));
        $addresses = $address_1;
    }
    if(!empty($address['address_2'])){
        $address_2 = array_values(json_decode($address['address_2'],true));
        $addresses = array_merge($addresses,$address_2);
    }
    if(!empty($address['address_3'])){
        $address_3 = array_values(json_decode($address['address_3'],true));
        $addresses = array_merge($addresses,$address_3);
    }

}else{

    $user_id = '';
    $groupid = '';
    $address = array();
}
function check($add,$area){
    foreach($add as $list){
        if(strpos($list,$area)!==false){

            return true;
        }
    }
    return false;
}

$datingSignup = \frontend\models\DatingSignup::findOne(['like_id'=>$contents['number'],'user_id'=>$user_id]);
$dating_signup_num = count(\frontend\models\DatingSignup::findAll(['like_id'=>$contents['number'],'status'=>0]));
$expire = time()-$contents['created_at'];
$contents['title2'] = empty($contents['title2'])?$contents['title']:$contents['title2'];
$contents['title3'] = empty($contents['title3'])?$contents['title']:$contents['title3'];

$girl_area = array($contents['title'],$contents['title2'],$contents['title3']);
$gong = array_intersect($area_china,$girl_area,$addresses);

$user = new \backend\models\User();
$user_wx = \frontend\modules\weixin\models\UserWeichat::findOne(['number'=>$user->getNumber($user_id)]);

if($groupid==3){

    if(!check($addresses,$contents['title'])&&!check($addresses,$contents['title2'])&&!check($addresses,$contents['title3'])){

        $modal = "#different";
        $content = "您的等级不足，当前等级报名仅限本地区";

    }elseif($expire>172800&&empty($gong)){

        $modal = "#different";
        $content = "您的等级不足，当前等级报名时间仅限妹子发布时间的48小时之内";

    }else{

        $modal_type = ($contents['worth']>$total)?"#recharge":"#register";
        $modal = empty($datingSignup)?$modal_type:"#registered";
        $content = "您已经报名！！";
    }

}elseif(in_array($groupid,[4,5])){

    $modal_type = ($contents['worth']>$total)?"#recharge":"#register";
    $modal = empty($datingSignup)?$modal_type:"#registered";
    $content = "您已经报名！！";

}else{

    $modal = "#different";
    $content = "对不起，您的等级不足!";
}


$this->registerCss('

        ul.share-buttons{list-style: none;padding: 0;}
        ul.share-buttons li{display: inline;}
        ol li{margin-bottom:15px;}
        .dating__signup{cursor: pointer;}
        .row{margin:0;}
        .hear-img{margin: 10px 6px;}
        .comment{display: inline-block;background-color: #DDD;padding:10px;width:100%;}
        .write-comment{margin: 0;padding:5px 15px;}
        .write-comment,
        .write-comment a{color:#ff1a10;}
        .gotop {background-image: url(../../../images/iconfont-fanhuidingbu.png);background-repeat: no-repeat;background-position: center center;background-size: 40px;height: 40px;width: 40px;position: fixed;right: 10px;bottom: 50px;z-index: 9999;cursor: pointer;}
        .sr-bdimgshare{z-index:-1 !important;}
        .flickity-viewport{padding-top:10px;height:344px !important;}
        .divas-wing{display:none !important;}
	     .divas-slide{background:transparent !important;}
	   
	        @media screen and (max-width: 500px) {
	        .divas-wing{display:none !important;}} 
          @media screen and (max-width: 375px) {
	        .divas-slide{height:250px !important;}
	        }  
	        @media screen and (min-width: 375px) {
	        .divas-slide{height:300px !important;}
	        }

    ');

if(isset($_GET['top'])&&$_GET['top']=='bottoms'){

    $this->registerCss('
        nav,footer,.suo-xia{display:none;}
    ');
}
$pre_url = Yii::$app->params['shisangirl'];
?>

<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>

<!--lunbo必要样式-->
<link id="skin" rel="stylesheet" type="text/css" media="screen" href="/css/auto/style.css" />
<link rel="stylesheet" href="/css/auto/amazeui.min.css" />
<script src="/js/datejs/amazeui.js"></script>
<style>
    .middle-img {
        position: absolute;
        left: 259px;
        top: 0px;
        width: 40px;
    }

    .up-img {
        position: absolute;
        top: -40px;
        left: 261px;
        width: 40px;
    }

    .down-img {
        position: absolute;
        top: 40px;
        left: 257px;
        width: 40px;
    }

    .left-img {
        position: absolute;
        left: 218px;
        width: 40px;
    }

    .right-img {
        position: absolute;
        left: 300px;
        width: 40px;
    }
    @media screen and (max-width:450px) {
        .middle-img {
            position: absolute;
            left: 259px;
            top: 0px;
            width: 40px;
            display: none;
        }

        .up-img {
            position: absolute;
            top: -40px;
            left: 261px;
            width: 40px;
            display: none;
        }

        .down-img {
            position: absolute;
            top: 40px;
            left: 257px;
            width: 40px;
            display: none;
        }

        .left-img {
            position: absolute;
            left: 218px;
            width: 40px;
            display: none;
        }

        .right-img {
            position: absolute;
            left: 300px;
            width: 40px;
            display: none;
        }

        .rotate_jia{
            display: none;
        }.rotate_div{
             display: none;
         }.rotate_jian{
              display: none;
          }
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){

        $("#slider").divas({
            slideTransitionClass: "divas-slide-transition-left",
            titleTransitionClass: "divas-title-transition-left",
            titleTransitionParameter: "left",
            titleTransitionStartValue: "-999px",
            titleTransitionStopValue: "0px",
            wingsOverlayColor: "rgba(0,0,0,0.1)"
        });

    });
</script>
<?php if(Yii::$app->session->hasFlash('success')):?>

    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">
            &times;
        </a>
        <strong>通知！</strong>
        <?=Yii::$app->session->getFlash('success')?>
    </div>
<?php endif;?>

<div class="container hear-list" style="padding:0;">
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-3 suo-xia">
            <?= $this->render('../layouts/dating_left')?>
        </div>
        <div class="col-md-9" style="padding: 0;">
            <div style="padding: 10px;background-color: #fff;margin: 5px 5px;"><?=date('Y-m-d',$contents['created_at'])?>    <span style="color:#3E4B8D;">十三觅约<?=$plate?>站</span></div>
            <section id="slider_wrapper" style="background-color: #fff;">
                <div id="slider" class="divas-slider" style="padding: 10px 0;background-color: #fff;">
                    <div class="divas-slide-container" data-am-widget="gallery" data-am-gallery="{ pureview: true }">
                        <?php foreach($photos['photos'] as $photo):?>
                            <a href="<?=$photo['path']?>" class="divas-slide am-gallery-item">
                                <img style="margin: 0 10px;box-shadow: 0 0 5px gray;" src="<?=$pre_url.$photo['path']?>" data-src="<?=$pre_url.$photo['path']?>"/>
                            </a>
                        <?php endforeach;?>
                    </div>
                    <div class="divas-navigation visible-lg">
                        <span class="divas-prev">&nbsp;</span>
                        <span class="divas-next">&nbsp;</span>
                    </div>

                    <div class="divas-controls visible-md">
                        <span class="divas-start"><i class="fa fa-play"></i></span>
                        <span class="divas-stop"><i class="fa fa-pause"></i></span>
                    </div>
                </div>
            </section>

            <div class="row" style="margin-top: 10px;">
                <div class="col-xs-6" style="padding-right: 5px;padding-left: 5px;">
                    <div class="row" style="background-color: #fff;padding:10px 0;border-radius: 5px;">
                        <div class="col-xs-4" style="padding:0 5px;">
                            <img style="width: 50px;" src="/images/dating/no.png">
                        </div>
                        <div class="col-xs-8">
                            <h6 style="margin-top: 5px;font-weight: bold;color: #E83F78;">妹子编号</h6>
                            <h5 style="margin-bottom: 0;font-weight: bold;"><?=$contents['number']?></h5>
                        </div>
                    </div>
                </div>
                <?php $chat = !empty($photos_chat['photos'])?$photos_chat['photos'][0]['path']:'';?>
                <div class="col-xs-6" style="padding-left: 5px;padding-right: 5px;">
                    <div class="row" style="background-color: #fff;padding:10px 0;border-radius: 5px;">
                        <div class="col-xs-4" style="padding:0 5px;">
                            <img style="width: 50px;" src="/images/dating/jietu.png">
                        </div>
                        <a class="col-xs-8" <?php if(!empty($chat)):?>href="<?=$pre_url.$chat?>" data-title="聊天截图" data-lightbox="s"<?php endif;?>>
                            <h6 style="margin-top: 5px;font-weight: bold;color: #E83F78;">聊天截图</h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 10px;">
                <?php $mark = explode('，',$contents['url']);$friend = explode('，',$contents['content']);?>
                <div class="col-xs-12" style="padding:0 5px;">
                    <div class="row" style="background-color: #fff;padding:10px 0;border-radius: 5px;">
                        <div class="col-xs-2" style="padding:0 5px;">
                            <img style="width: 50px;" src="/images/dating/biaoqian.png">
                        </div>
                        <div class="col-xs-8">
                            <h6 style="margin-top: 5px;font-weight: bold;color: #E83F78;">妹子标签</h6>
                            <h5 style="margin-bottom: 0;font-weight: bold;"><?=implode(',',$friend)?></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 10px;">
                <div class="col-xs-12" style="padding:0 5px;">
                    <div class="row" style="background-color: #fff;padding:10px 0;border-radius: 5px;">
                        <div class="col-xs-2" style="padding:0 5px;">
                            <img style="width: 50px;" src="/images/dating/yaoqiu.png">
                        </div>
                        <div class="col-xs-8">
                            <h6 style="margin-top: 5px;font-weight: bold;color: #E83F78;">交友要求</h6>
                            <h5 style="margin-bottom: 0;font-weight: bold;"><?=implode(',',$mark)?></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 10px;">
                <div class="col-xs-12" style="padding:0 5px;">
                    <div class="row" style="background-color: #fff;padding:10px 0;border-radius: 5px;">
                        <div class="col-xs-12" style="padding:0 10px;">
                            <?php if(!empty($contents['introduction'])):?>
                                <?=$contents['introduction']?>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if(!Yii::$app->user->isGuest):?>
                    <div class="row text-center" style="margin-top: 10px;">
                        <div class="col-xs-12" style="padding:0 5px;">
                            <div class="row" style="background-color: #fff;padding:10px 0;border-radius: 5px;">
                                <div class="col-xs-12" style="padding:0 5px;">
                                    所需节操币：<span style="font-size: 20px;color: #E83F78;"><?=$contents['worth']?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if($dating_signup_num>=10):?>
                        <div class="row" style="padding: 8px 0;margin-top: 20px;">
                            <div style="width: 40%;background-color: #fff;border-radius: 30px;text-align: center;color:#E83F78;margin: auto;padding:10px 0;font-size: 18px;box-shadow: 0 0 10px #d2d2d2;">
                                待开放中
                            </div>
                        </div>
                    <?php else:?>
                        <div class="row" style="margin-top: 30px;">
                            <div class="dating__signup" data-sum="<?=$dating_signup_num?>" data-content="<?=$content?>" data-worth="<?=$contents['worth']?>" data-avatar="<?=$pre_url.$contents['avatar']?>" data-toggle="modal" data-target="<?=$modal?>" data-number="<?=$contents['number']?>">
                                <div style="width: 40%;background-color: #fff;border-radius: 30px;text-align: center;color:#E83F78;margin: auto;padding:10px 0;font-size: 18px;box-shadow: 0 0 10px #d2d2d2;">
                                    <span class="glyphicon glyphicon-plus"></span> 求推荐
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
            <?php else:?>
                <a href="/login" class="row">
                    <div style="width: 40%;background-color: #fff;border-radius: 30px;text-align: center;color:#E83F78;margin: auto;margin-top: 30px;padding:10px 0;font-size: 18px;box-shadow: 0 0 10px #d2d2d2;">
                        <span class="glyphicon glyphicon-plus"></span> 求推荐
                    </div>
                </a>
            <?php endif;?>
        </div>
    </div>

    <script>
        $('.liaotianjietu').on('click',function () {
            alert('暂未开放');
        });
    </script>


    <!--<div style="background-color: #EF4450;border-radius: 5px;color:white;padding: 10px;margin-top: 10px;font-size: 16px;margin-bottom: 10px;">
        加微信客服约约约：<?/*=Yii::$app->params['girl']*/?>
    </div>
    <div class="row write-comment">
        <span class="pull-right">
            <a href="<?/*=\yii\helpers\Url::to(['/weekly-comment/create','id'=>$weekly_id])*/?>">写留言</a>
            <i class="glyphicon glyphicon-pencil"></i>
        </span>
    </div>

    <hr style="border-top: 1px solid #98b7a8;">

    <h5 class="text-center">游客留言区</h5>

    <div class="row" style="min-height: 100px;">
        <?php /*foreach($comments as $comment):*/?>
            <div class="comment">
                <div class="col-xs-10" style="padding: 0;">游客：<?/*=HtmlPurifier::process(Html::encode(strip_tags($comment['content'])))*/?></div>
                <div class="col-xs-2" style="padding-right:0;">
                    <div class="comment-likes" onclick="return notes(<?/*=$comment['id']*/?>,this)">
                        <span class="glyphicon glyphicon-thumbs-up"></span>
                        <span style="margin-left: 5px;" class="comment-count"><?/*=$comment['likes']*/?></span>
                    </div>
                </div>
            </div>
        <?php /*endforeach;*/?>
    </div>-->
</div>
<!-- <script>
    function notes(id,con){
        var cons = $(con);
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function stateChanged()
        {
            if (xhr.readyState==4 || xhr.readyState=="complete")
            {
                cons.children('.comment-count').html(xhr.responseText);
            }
        };
        xhr.open('get','/index.php/site/note?id='+id);
        xhr.send(null);
    }

</script> -->

<?=$this->render('/layouts/date_modal',['total'=>$total])?>

