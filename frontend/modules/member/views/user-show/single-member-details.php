<?php
$this->title = $model['member_name'];
$discount = $model['discount']*100;
$discount = $discount==100?"无":$discount.'折';
$this->registerCss("

    .navbar{margin-bottom:0;}
    .member-details{padding:10px 5px;background-color: #fff;}
    .member-details .col-xs-4{padding:0;}
    .member-details .btn{background-color:#22212d;color:#FFC441;padding:6px 40px;}
    .btn:hover, .btn:focus, .btn.focus{color:#fff;}
    .nav-tabs{border:none;}
    .nav > li > a{padding:6px 8px;}
    .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus{background-color:#E83F78;color:#fff;}
    .nav-tabs > li > a{border-radius:3px;}
    .member-details .col-xs-6{width:49%;}
    @media (min-width:768px){

    .member-details{width:450px;margin:auto;}

    }
");

?>
<div class="row member-center">
    <header>
        <div class="header">
            <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
            <h2 style="margin:0;"><?=$this->title?></h2>
            <?php if(Yii::$app->user->identity->groupid<intval($model['groupid'])):?>
                <a style="right:3%;top:2px;font-size:14px;line-height: 44px;position: absolute;" href="pay-type?id=<?=$model['id']?>">升级</a>
            <?php endif;?>
        </div>
    </header>
</div>
<div class="row member-details" style="background:url('/images/member/member-background-image-02.jpg');background-size:cover;">
    <div class="center-block" style="border:1px solid #FFC441;border-radius:50%;width:90px;height:90px;line-height:100px;"><img class="center-block" style="width: 70px;margin-top:10px;" src="<?=$img?>"></div>
    <h4 class="text-center" style="font-weight: bold;color:#fff;margin-top:15px;margin-bottom:0px;"><?=$model['member_name']?></h4>
</div>
<div class="row member-details">
    <h5 class="col-xs-6" style="font-weight: bold;text-align: left;">原价：<?=$model['price']?>元</h5>
    <h5 class="col-xs-6" style="font-weight: bold;text-align: right;">折扣：<?=$discount?></h5>
    <div class="clearfix"></div>

    <?php if(Yii::$app->user->identity->groupid>=intval($model['groupid'])):?>

        <h5 class="text-center">您已是<?=$level?>，无需升级</h5>

    <?php else:?>
        <h5 class="text-center">您现在是<?=$level?>，还需支付</h5>
        <h3 class="text-center" style="margin-top: 0;margin-bottom: 0;"><?=$need_price?>元</h3>
    <?php endif;?>
</div>


<?php if(Yii::$app->user->identity->groupid<intval($model['groupid'])):?>
    <div class="row member-details text-center">
            <a class="btn" href="pay-type?id=<?=$model['id']?>">升级</a>
    </div>
<?php endif;?>





<div class="row member-details" style="background-color: #F0EFF5;">

    <!--会员简介和权限-->
    <div class="permissions-introduce">
        <ul id="introduceTab" class="nav nav-tabs text-center" style="background-color: #fff;padding:10px;">
            <li class="active" style="width:50%;">
                <a href="#permissions" data-toggle="tab">会员特权</a>
            </li>
            <li style="width:50%;">
                <a href="#introduce" data-toggle="tab">会员简介</a>
            </li>
        </ul>
        <div id="introduceTabContent" class="tab-content" style="min-height: 150px;">
            <div class="tab-pane fade in active" id="permissions">
                <?php foreach ($permissions as $key=>$permission):
                    $name = explode('：',$permission)[0];
                    $content = explode('：',$permission)[1];
                    $width = in_array($key,[1,2,3,4])?'col-xs-6':'col-xs-12';
                    $right = in_array($key,[1,3])?'margin-right:2%;':'';
                    ?>

                    <div class="<?=$width?>" style="padding:10px 5px;text-align: center;border-radius: 3px;margin-top:8px;background-color: #fff;<?=$right?>">
                        <h4 style="font-size: 14px;"><?=$name?></h4>
                        <h4 style="color:#E83F78;font-size: 14px;"><?=$content?></h4>
                    </div>

                <?php endforeach;?>

            </div>
            <div class="tab-pane fade" id="introduce">
                <p style="background-color: #fff;padding:10px;margin-top: 10px;"><?=$model['member_introduce']?></p>
            </div>
        </div>
    </div>

</div>