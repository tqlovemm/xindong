<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use \yii\myhelper\AccessToken;
$this->title = '今日密约';
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
$this->registerCss('
        a:hover{text-decoration: none;color:black;}

        .date-today{padding:0 5px;font-size:12px;}
        .date-today .row{margin:0;}
        .date-today spant{color:#636363;}
        .date-today .col-md-6{background-color:#fff;padding:10px 10px 0;margin-bottom:10px;border:1px solid #EDEDF1;box-shadow: 0 0 0 1px #ededee;border-radius:4px;}

        .date-number span{font-size:14px;}
        .date-mark,.date-friend {line-height:26px;}
        .date-mark span,.date-friend span{padding:1px 3px;color:white;border-radius:3px;white-space:nowrap;}
        .date-mark span{background-color:#ef4450;}
        .date-friend span{background-color:#3e4b8d;}

        .row1-n1{width:99%;background-color: white;box-shadow: 0 0 5px #dbdbdb;padding:20px;height: inherit;margin-bottom: 10px;}
        .dating__signup{cursor: pointer;}
        @media (min-width:768px){
            .date-today{font-size:14px;}
            .date-today .col-md-6{width:49%;margin-right:1%;}
        }

        @media (max-width:768px){
            #weibo__show{display:none;}
         
            .date-today{padding:10px 5px;}
            .date-number,.date-mark,.date-friend {line-height:28px;}
            .row1-n1{width:100%;padding:5px 0;}
            #weibo__guanzhu{display:none;}
        }

');

if(isset($_GET['top'])&&$_GET['top']=='bottoms'){

    $this->registerCss('
        nav,footer,.suo-xia{display:none;}
    ');
}
$rand_url = AccessToken::antiBlocking();
$pre_url = Yii::$app->params['shisangirl'];
?>
<!--    <wb:topic topmid="DsAXCFjFp" column="n" border="n" width="560" height="1580" tags="%E7%94%B7%E5%A5%B3%E7%BA%A6%E4%BC%9A%E6%98%AF%E5%90%A6%E5%AE%8C%E5%85%A8%E8%AE%A9%E7%94%B7%E7%94%9F%E4%B9%B0%E5%8D%95" red_text="%E5%BD%93%E7%84%B6%E5%BA%94%E8%AF%A5%E7%94%B7%E7%94%9F%E4%B9%B0%E5%8D%95" blue_text="%E7%94%B7%E5%A5%B3%E5%B9%B3%E7%AD%89" language="zh_cn" version="pk" appkey="5ioQwE" refer="y" footbar="y" url="http%3A%2F%2F13loveme.com%2Fdate-today" filter="n" ></wb:topic> -->
<!--不要提交-->
<?php if(Yii::$app->session->hasFlash('success')):?>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">
            &times;
        </a>
        <strong>通知！</strong>
        <?=Yii::$app->session->getFlash('success')?>
    </div>
<?php endif;?>
<div class="container">

    <div class="row">
        <div class="col-md-3 suo-xia">
            <?= $this->render('../layouts/dating_left')?>
        </div>

        <div class="col-md-9 date-today">

            <div class="row1-n1">
                <a class="btn" style="<?php if(Yii::$app->request->getPathInfo()=='date-today'){echo 'color:rgba(239, 68, 80, 1);';}?>" href="/date-today?url=<?=$rand_url?>">
                    <i class=" glyphicon glyphicon-certificate"></i>&nbsp;今日觅约</a>
                <a class="btn" href="/red?url=<?=$rand_url?>">
                    <i class="glyphicon glyphicon-time"></i>&nbsp;往日觅约</a>
                <a class="btn pull-right" href="#" style="margin-right: 10px;" data-toggle="modal"
                   data-target="#myModal">
                    <i class="glyphicon glyphicon-search"></i>&nbsp;
                </a>

            </div>
            <!-- 模态框（Modal） -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close"
                                    data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">
                                输入你要搜索的女生编号
                            </h4>
                        </div>
                        <div class="modal-body">
                            <form action="/date-today?type=2016" method="get" class="sidebar-form">
                                <div class="input-group">
                                    <input type="text" name="number" class="form-control" placeholder="请输入女生编号" required>
                        <span class="input-group-btn">
                            <button type="submit" name="type" value="2016" id="search-btn" class="btn btn-flat"><i class="glyphicon glyphicon-search"></i></button>
                        </span>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal -->
            </div>
            <div class="row" style="min-height: 500px;">
                <?php foreach ($model as $item):

                    $datingSignup = \frontend\models\DatingSignup::findOne(['like_id'=>$item['number'],'user_id'=>$user_id]);
                    $dating_signup_num = count(\frontend\models\DatingSignup::findAll(['like_id'=>$item['number'],'status'=>0]));
                    $expire = time()-$item['created_at'];

                    $operate = ($item['cover_id']==-1)?'<span class="glyphicon glyphicon-remove"></span>已失效':'等待开放中';

                    $item['title2'] = empty($item['title2'])?$item['title']:$item['title2'];
                    $item['title3'] = empty($item['title3'])?$item['title']:$item['title3'];
                    $girl_area = array($item['title'],$item['title2'],$item['title3']);
                    $gong = array_intersect($area_china,$girl_area,$addresses);

                    if($groupid==3){

                        if(!check($addresses,$item['title'])&&!check($addresses,$item['title2'])&&!check($addresses,$item['title3'])){

                            $modal = "#different";
                            $content = "您的等级不足，当前等级报名仅限本地区";

                        }elseif($expire>172800&&empty($gong)){

                            $modal = "#different";
                            $content = "您的等级不足，当前等级报名时间仅限妹子发布时间的48小时之内";

                        }else{

                            $modal_type = ($item['worth']>$total)?"#recharge":"#register";
                            $modal = empty($datingSignup)?$modal_type:"#registered";
                            $content = "您已经报名！！";
                        }

                    }elseif(in_array($groupid,[4,5])){


                        $modal_type = ($item['worth']>$total)?"#recharge":"#register";
                        $modal = empty($datingSignup)?$modal_type:"#registered";
                        $content = "您已经报名！！";


                    }else{

                        $modal = "#different";
                        $content = "对不起，您的等级不足!";
                    }

                    $marks = array_filter(explode('，',$item['content']));
                    $friends = array_filter(explode('，',$item['url'])); ?>
                    <div class="col-md-6 col-sm-6">

                        <div class="row" style="margin: 0;position: relative;border-bottom: 1px solid #efefef;padding-bottom: 8px;">
                            <a class="<?php if($item['cover_id']==-1){echo "content_link";}?>"  href="<?=Url::to(["/date-view/$item[id]",'url'=>$rand_url])?>">
                                <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10" style="padding: 0;vertical-align: middle;">
                                    <div class="date-number">
                                        <spant>妹子编号</spant>
                                        <span><?=$item['number']?></span>
                                    </div>
                                    <div class="date-mark">
                                        <spant>妹子标签</spant>
                                        <?php foreach($marks as $num=>$mark):?>
                                            <?php if($num==3){break;}?>
                                            <span><?=$mark?></span>
                                        <?php endforeach;?>
                                    </div>
                                    <div class="date-friend">
                                        <spant>交友要求</spant>
                                        <?php foreach($friends as $num=>$friend):?>
                                            <?php if($num==4){break;}?>
                                            <span><?=$friend?></span>
                                        <?php endforeach;?>
                                    </div>
                                </div>
                                <?php if($item['cover_id']==-1):?>
                                <div class="col-sm-3 col-xs-3 col-md-2 col-lg-2" style="padding: 0;position: relative;">
                                    <img style="opacity:0.1;filter:alpha(opacity=10);" class="img-responsive center-block lazy date-today-img" alt="<?=$item['url']?>" title="<?=$item['content']?>" data-original="<?=$pre_url.$item['avatar']?>">
                                    <img src="/images/dating/seal.png" style="position: absolute;top:50%;right:50%;width: 60px;margin-top: -30px;margin-right: -30px;">
                                </div>
                                    <script>

                                        $(function () {
                                            $('.date-today-img',this).each(function () {
                                                var width = $(this).width();
                                                $(this).height(width);
                                            });

                                        });

                                        $('.content_link').click(function () {
                                            $(".content_link").removeAttr("href");
                                            return false;
                                        });

                                    </script>
                                <?php else:?>
                                <div class="col-sm-3 col-xs-3 col-md-2 col-lg-2" style="padding: 0;">
                                    <img class="img-responsive center-block lazy date-today-img" alt="<?=$item['url']?>" title="<?=$item['content']?>" data-original="<?=$pre_url.$item['avatar']?>">
                                </div>
                                <?php endif;?>
                            </a>
                        </div>
                    <?php if(Yii::$app->user->isGuest):?>
                        <div class="row text-center" style="font-size: 14px;">
                            <a href="/contact" class="col-xs-6"  style="padding: 8px 0;visibility: hidden;">
                                我要入会
                            </a>
                            <a class="col-xs-6 dating__signup" href="/login" style="padding: 8px 0;border-left: 1px solid #efefef;">
                                <span class="glyphicon glyphicon-plus" style="font-size: 12px;"></span> 求推荐
                            </a>
                        </div>
                    <?php else:?>
                        <div class="row text-center" style="font-size: 14px;">
                            <div class="col-xs-6"  style="padding: 8px 0;border-right: 1px solid #efefef;">
                                需节操币 <?=$item['worth']?>
                            </div>
                            <?php if($dating_signup_num>=10||$item['cover_id']==-1):?>
                                <div class="col-xs-6" style="padding: 8px 0;"><?=$operate?></div>
                            <?php else:?>
                                    <div class="col-xs-6 dating__signup" data-sum="<?=$dating_signup_num?>" data-content="<?=$content?>" data-worth="<?=$item['worth']?>" data-avatar="<?=$pre_url.$item['avatar']?>" data-toggle="modal" data-target="<?=$modal?>" style="padding: 8px 0;" data-number="<?=$item['number']?>">
                                        <span class="glyphicon glyphicon-plus" style="font-size: 12px;"></span>求推荐
                                    </div>
                            <?php endif;?>
                        </div>
                    <?php endif;?>
                    </div>
                <?php endforeach;?>
            </div>
            <div class="row text-center">
                <?= LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>0]); ?>
            </div>
        </div>
    </div>
    <?=$this->render('/layouts/bottom')?>
</div>
<?php
    $this->registerJs("
        $(function() {
            $('img.lazy').lazyload({effect: 'fadeIn'});
        });
    
    ");
?>
<?=$this->render('/layouts/date_modal',['total'=>$total])?>

<?php
$groupid = empty(Yii::$app->user->identity->groupid)?null:Yii::$app->user->identity->groupid;
$cookie = Yii::$app->request->cookies;
if($groupid==2&&empty($cookie->get('gd_zz_sy'))):?>
    <div class="gd_zz_sy" style="width: 100%;height: 100%;background-color: rgba(149, 149, 149, 0.79);position: fixed;top:0;display: none;">
        <div class="center-block sy_card" style="width: 90%;display: none;padding:0 8px 8px 8px;background-color: #f4f3f9;position: relative;top:50%;margin-top: -150px;border-radius: 10px;">
            <span id="close_sy" style="font-size: 22px;color:#a0a0a0;">&times;</span>
            <h4 class="text-center">升级会员获取更多权限</h4>
            <a href="/member/user-show/member-show"><img style="max-width: 100%;margin-top: 5px;" src="/images/dating/gaoduan.png"></a>
            <a href="/member/user-show/member-show"><img style="max-width: 100%;margin-top: 15px;" src="/images/dating/zhizun.png"></a>
            <p style="margin-top: 10px;text-align: center;"><a href="/member/user-show/member-show">至尊高端会员特权详情 &nbsp;>></a></p>
        </div>
    </div>
<?php endif;?>

<script>
    setTimeout(function () {
        $('.gd_zz_sy').fadeIn(200,function () {
            $('.sy_card').slideDown(1000);
        });
        $('#close_sy').on('click',function () {
            $('.sy_card').slideUp(1000,function () {
                $('.gd_zz_sy').fadeOut(200);
            });
        });
    },1000);
</script>
