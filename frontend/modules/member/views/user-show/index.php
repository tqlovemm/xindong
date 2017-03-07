<?php
$this->title = '会员等级';
$this->registerCss("

            /*phone*/

    .avatar{padding:10px;color:#fff;}
    .member-info{font-size:12px;}
    .member-info .col-xs-6{width:49%;}
    .member-info .info-box{padding: 40px 15px;}
    .member-info .info-box .icon-bar{text-align: center;font-size: 25px;margin-bottom: 10px;}
    .info-content {color:gray;}
    .member-info{margin:0 -10px;}
    .box2{border-bottom: 1px #E6E6E6 solid;}
    .box3{border-right: 1px #E6E6E6 solid;}

    .member-list{font-size:12px;background:#fff;margin-top:10px;padding:10px 6px;}
 

    ");
?>

<div class="row member-center">
    <header>
        <div class="header">
            <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
            <h2 style="margin:0;"><?=$this->title?></h2>
            <a id="list_01" href="/member/setting" class="	glyphicon glyphicon-cog"  style="right:3%;top:0;font-size:20px;line-height: 44px;position: absolute;"></a>
        </div>
    </header>
</div>
<div class="row avatar text-center" style="background:url('/images/member/member-background-image-02.jpg');background-size:cover;">

    <img class="img-responsive center-block img-circle" style="width: 80px;" src="<?=Yii::getAlias('@web')?>/images/member/gaoduan.png">
    <h3 style="color:gray;margin-top: 0;"><?=$level?></h3>
    <h6 style="color:gray;margin-top: 0;">当前会员等级</h6>

    <a href="user-show/member-show" class="btn" style="background-color: #2c2c2c;color:#D4A124;margin-bottom: 15px;font-size: 16px;">升级获取更多权限</a>

</div>
<div class="row" style="background-color: #fff;border-bottom: 1px solid #E6E6E6;padding:10px 5px;margin-top: 5px;">
    <span class="pull-left">会员特权</span>
    <span class="pull-right"><a href="/test/user-how-play" style="color:#333;">会员须知</a></span>
    <span class="pull-right bl_more" style="color:gray;"></span>
</div>
<div class="row member-info">
    <?php if(in_array(Yii::$app->user->identity->groupid,[3,4])):?>
        <?php foreach ($permissions as $key=>$permission):
            $name = explode('：',$permission)[0];
            $content = explode('：',$permission)[1];
            $width = in_array($key,[1,2,3,4])?'col-xs-6':'col-xs-12';
            $right = in_array($key,[1,3])?'margin-right:2%;':'';
            ?>

            <div class="<?=$width?>" style="padding:10px;text-align: center;border-radius: 3px;margin-top:8px;background-color: #fff;<?=$right?>">
                <h4 style="font-size: 14px;"><?=$name?></h4>
                <h4 style="color:#E83F78;font-size: 14px;"><?=$content?></h4>
            </div>

        <?php endforeach;?>
<!--    <?php /*foreach($permissions as $key=>$permission):
        $name = explode('：',$permission)[0];
        $content = explode('：',$permission)[1];
        if($num%2==0){
            if($key%2==0){
                if($key==($num-2)){$border = "border-right:1px solid #e3e3e3;";}else{$border = "border-bottom:1px solid #e3e3e3;border-right:1px solid #e3e3e3;";}
            }else{
                if($key==($num-1)){$border = "";}else{$border = "border-bottom:1px solid #e3e3e3;";}
            }
        }else{
            if($key%2==0){
                if($key==($num-1)){$border = "border-right:1px solid #e3e3e3;";}else{$border = "border-bottom:1px solid #e3e3e3;border-right:1px solid #e3e3e3;";}
            }else{
                $border = "border-bottom:1px solid #e3e3e3;";
            }
        } */?>
        <div class="col-xs-6" style="padding:10px;text-align: center;<?/*=$border*/?>">
            <h4 style="font-size: 14px;"><?/*=$name*/?></h4>
            <h4 style="color:#E83F78;font-size: 14px;"><?/*=$content*/?></h4>
        </div>
    --><?php /*endforeach;*/?>

    <?php else:?>
    <h5 class="text-center">当前等级在网站暂无特权,您可以升级哦</h5>
    <?php endif;?>
</div>
<div class="row member-list" style="margin-bottom: 50px;">
    <a href="user-show/member-show">
        <div>其他会员特权</div>
    </a>
</div>
