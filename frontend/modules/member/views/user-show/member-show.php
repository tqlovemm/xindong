<?php
$this->title = "会员展";
$this->registerCss("
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
    .member-index{max-width:500px;margin:auto;}
");
$pre_url = Yii::$app->params['threadimg'];
?>
<div class="member-index">
<div class="row member-center">
    <header>
        <div class="header">
            <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
            <h2 style="margin:0;"><?=$this->title?></h2>
            <a id="list_01" href="/member/setting" class="glyphicon glyphicon-cog" style="right:3%;top:0;font-size:20px;line-height: 44px;position: absolute;"></a>
        </div>
    </header>
</div>
<div class="row" style="background-color: #fff;margin-bottom: 10px;">
    <a class="link-icon" href="http://mp.weixin.qq.com/s/IhEg7rG-ls01lFpBAGri6w">
        <img class="img-responsive" src="/images/member/introduction.png">
        <h6>平台简介</h6>
    </a>
    <a class="link-icon" href="http://mp.weixin.qq.com/mp/homepage?__biz=MzAxMDIwMDIxMw==&hid=1&sn=a00a64d7d9db13c2540a42fe460d223d#wechat_redirect">
        <img class="img-responsive" src="/images/member/wechat.png">
        <h6>公众号</h6>
    </a>
    <a class="link-icon" href="/services">
        <img class="img-responsive" src="/images/member/service.png">
        <h6>十三服务</h6>
    </a>
    <a class="link-icon" href="/about">
        <img class="img-responsive" src="/images/member/aboutus.png">
        <h6>关于我们</h6>
    </a>
    <a class="link-icon" href="/attention/problem">
        <img class="img-responsive" src="/images/member/question.png">
        <h6>十三问答</h6>
    </a>
</div>
<?php foreach($model as $key=>$item):?>
<div class="row member-upgrade <?php if($item['is_recommend']==1):?>upgrade-color-black<?php else:?>upgrade-color-white<?php endif;?>">
    <a class="upgrade-box clearfix" href="update-details?id=<?=$item['id']?>">
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