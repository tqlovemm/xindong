<?php
$this->title = $query['member_name'];
$discount = $query['discount']*100;
$discount = $discount==100?"无":$discount.'折';
$this->registerCss("

    .navbar{margin-bottom:0;}
    .member-details{background-color: #fff;}
    .member-details .col-xs-4{padding:0;}
    .member-details .btn{background-color:#22212d;color:#FFC441;padding:6px 40px;}
    .btn:hover, .btn:focus, .btn.focus{color:#fff;}
    .nav-tabs{border:none;}
    .nav > li > a{padding:6px 8px;}
    .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus{background-color:#E83F78;color:#fff;}
    .nav-tabs > li > a{border-radius:3px;}
    .member-details .col-xs-6{width:49%;}
    .join-member h5{font-weight:bold;}
    .join-member ul{margin-bottom: 0;list-style: none;}
    .join-member ul li{padding:5px;}
    @media (min-width:768px){
        .member-index{width:500px;margin:auto;}
    }
    
    .member-upgrade{border-bottom:1px solid #f3f3f3;margin-bottom:10px;}
    .upgrade-color-black{background-color:#494949;}
    .upgrade-color-black h2{color:#fff;}
    .upgrade-color-black h3{color:#FFC41F;}
    .upgrade-color-white{background-color:#fff;}
    .upgrade-color-white h2{color:#000;}
    .upgrade-color-white h3{color:#EB5B8C;}
    .member-icon{width:100%;}
    .upgrade-box div{padding:0;}
    .link-icon{width: 20%;float: left;display: block;padding:6px;}
    .link-icon h6{text-align:center;}
");
$join_member_process = explode('@',$query['member_introduce']);
$join_member_permissions = explode('@',$query['permissions']);
$pre_url = Yii::$app->params['threadimg'];
$price = isset($model['price'])?$model['price']:$query['price_1'];
$uid = !empty(Yii::$app->request->get('uid'))?"&top=1&uid=".Yii::$app->request->get('uid'):"";
?>
<div class="member-index" style="padding-bottom: 50px;">
    <?php if(empty(Yii::$app->request->get('top'))):?>
    <div class="row member-center">
        <header>
            <div class="header">
                <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
                <h2 style="margin:0;"><?=$this->title?></h2>
                <?php if(!Yii::$app->user->isGuest):?>
                <?php if(Yii::$app->user->identity->groupid<intval($model['groupid'])):?>
                    <a style="right:3%;top:2px;font-size:14px;line-height: 44px;position: absolute;" href="pay-type?id=<?=$model['id']?>">升级</a>
                <?php endif;?>
                <?php endif;?>
            </div>
        </header>
    </div>
    <?php endif;?>
    <div class="row member-details" style="margin-bottom: 10px;">
        <div class="center-block">
            <img class="img-responsive" src="<?=$pre_url.$query->top->img_path?>">
        </div>
    </div>
    <div class="row member-details" style="margin-bottom: 10px;padding-bottom:10px;">
        <h4 class="col-xs-12">十三平台<?=$query['member_name']?></h4>
        <div class="clearfix"></div>
        <h5 class="col-xs-3" style="color:#EA5285;"><span class="glyphicon glyphicon-jpy"></span><?=$price?></h5>
        <h5 class="col-xs-3" style="color:#EA5285;padding:0;">折扣：<?=$discount?></h5>
        <h5 class="col-xs-6" style="padding:0;color: #aaa;">
            <span class="glyphicon glyphicon-map-marker"></span> <?php if(isset($model['address'])){echo $model['address'];}?><span>&nbsp;&nbsp;&nbsp;19584会员</span>
        </h5>
        <div class="clearfix"></div>
        <?php if($group_id>=intval($model['groupid'])):?>
            <h5 class="text-center" style="color: #aaa;margin-top: 0;">您已是<?=$level?>，无需升级</h5>
        <?php else:?>
            <h5 class="text-center" style="color: #aaa;margin-top: 0;">您现在是<?=$level?>，还需支付</h5>
            <h3 class="text-center" style="margin-top: 0;margin-bottom: 0;color: #aaa;"><?=$need_price?>元</h3>
        <?php endif;?>
    </div>
    <h5 style="color: #aaa;margin-top: 0;">升级赠送</h5>
    <div style="background-color: #fff;margin: 0 -15px 10px -15px;">
        <div class="row" style="margin: 0;border-top: 1px solid #eee;">
            <div style="padding-right: 10px;float: left;padding-left: 10px;"><img style="width: 40px;" class="img-responsive" src="/images/member/zeng.png"></div>
            <div style="float: left;line-height: 40px;"><?=$query['giveaway']?>节操币</div>
        </div>
        <div class="row" style="margin: 0;border-top: 1px solid #eee;">
            <div style="padding-right: 10px;float: left;padding-left: 10px;"><img style="width: 40px;" class="img-responsive" src="/images/member/zeng.png"></div>
            <div style="float: left;line-height: 40px;"><?=$query['giveaway_qun']?></div>
        </div>
    </div>
    <div class="row">
        <?php foreach ($query->images as $item):?>
            <img class="img-responsive" style="margin-bottom: 10px;" src="<?=$pre_url.$item['img_path']?>">
        <?php endforeach;?>
    </div>
    <h5 style="color: #aaa;margin-top: 0;">平台服务说明</h5>
    <div class="row member-details" style="background-color: #fff;margin-bottom: 10px;">
        <div class="row" style="margin: 0;padding:10px;">
            <div class="col-xs-2" style="padding-left: 0;padding-right: 0;">
                <img style="width: 59px;" class="img-responsive center-block" src="/images/member/kefu.png">
            </div>
            <div class="col-xs-10" style="padding: 0 0 0 15px;font-size: 14px;">
                <h4 style="font-weight: bold;">咨询客服</h4>
                <p style="margin-bottom: 0;color: #aaa;">入会过程总如果有其他问题，可以咨询客服</p>
            </div>
        </div>
        <div class="row" style="margin: 0;border-top: 1px solid #eee;padding:10px;">
            <div class="col-xs-2" style="padding-left: 0;padding-right: 0;">
                <img style="width: 59px;" class="img-responsive center-block" src="/images/member/recognized.png">
            </div>
            <div class="col-xs-10" style="padding: 0 0 0 15px;font-size: 14px;">
                <h4 style="font-weight: bold;">十三平台官方保障</h4>
                <p style="margin-bottom: 0;color: #aaa;">会员隐私严格保密，平台女生都经过验证，保证真实，如发现损害会员利益的，将严肃处理。</p>
            </div>
        </div>
    </div>
    <h5 style="color: #aaa;margin-top: 0;">购买须知</h5>
    <div class="row member-details join-member" style="background-color: #fff;padding:10px;margin-bottom: 10px;">
        <h5>一.注册流程</h5>
        <ul class="list-group">
        <?php foreach ($join_member_process as $key=>$item):?>
            <li>1.<?=$key+1?>：<?=$item?></li>
        <?php endforeach;?>
        </ul>
        <h5>二.十三平台声明</h5>
        <ul class="list-group">
            <?php foreach ($join_member_permissions as $key=>$item):?>
                <li>2.<?=$key+1?>：<?=$item?></li>
            <?php endforeach;?>
        </ul>
    </div>
    <h5 style="color: #aaa;margin-top: 0;">十三平台其他会员</h5>
    <?php foreach($model_member as $key=>$item):?>
    <div class="row member-upgrade <?php if($item['is_recommend']==1):?>upgrade-color-black<?php else:?>upgrade-color-white<?php endif;?>">
        <a class="upgrade-box clearfix" href="update-details?id=<?=$item['id']?><?=$uid?>">
            <div class="col-xs-6">
                <div class="member-icon">
                    <img class="img-responsive" src="<?=$pre_url.$item['cover']['img_path']?>">
                </div>
            </div>
            <div class="col-xs-6" style="position: relative;padding-left: 10px;">
                <h2><?=$item['member_name']?></h2>
                <h3 style="font-weight: bold;"><span class="glyphicon glyphicon-jpy"></span><?=$item['price_1']?></h3>
                <p><span style="background-color: #eee;padding:1px 8px;border-radius: 30px;color:gray;">特权详情 ></span></p>
                <?php if($item['is_recommend']==1):?><img style="position: absolute;top:0;right:0;width: 35%;" src="/images/member/recommend.png"><?php endif;?>
            </div>
        </a>
    </div>
    <?php endforeach;?>
</div>
<div style="position: fixed;bottom:0;left:0;width: 100%;padding: 0;">
    <a <?php if(!Yii::$app->user->isGuest):?> data-title="客服微信" data-lightbox="fads" href="/images/weixin/thirteenpingtai.jpg" <?php else:?> onclick="consultation()" <?php endif;?> style="float: left;width: 30%;background-color: #fff;padding:10px;font-size: 16px;border-top: 1px solid #ddd;">
        <img style="width: 30px;" src="/images/member/chat.png"> 咨询
    </a>
    <a <?php if(!Yii::$app->user->isGuest): if(Yii::$app->user->identity->groupid<intval($model['groupid'])):?>href="<?=\yii\helpers\Url::to(['pay-type','id'=>$model['id']])?>"<?php else:?>data-confirm="您无需升级"<?php endif; else:?> onclick="upgrade({'upgrade_id':<?=$update_id?>,'original_price':<?=$price?>,'preferential_price':<?=$need_price?>})" <?php endif;?> style="float: left;width: 70%;background-color: #000;padding:10px;font-size: 24px;color:#FFA72A;text-align: center;line-height: 30px;display: block;border-top: 1px solid #000;">
        升级会员 >>>
    </a>
</div>
<script type="text/javascript">

    function consultation() {
        var url= "咨询";
        window.webkit.messageHandlers.consultation.postMessage(url);
    }

    function upgrade(param) {

        window.webkit.messageHandlers.upgrade.postMessage(param);
    }

</script>