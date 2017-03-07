<?php
use yii\myhelper\Helper;
$this->title = "会员展";
$this->registerCss("
        .member-upgrade{padding:10px;background-color:#fff;border-bottom:1px solid #f3f3f3;}
        .member-icon{width:50px;height:50px;}
        .upgrade-box div{padding:0;}
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
<?php 

    $groupid = array();
    foreach($query as $key=>$list):
        $groupid[$list['groupid']] = $list['sum'];
    endforeach;

?>
<?php foreach($model as $key=>$item):
    switch($key){
        case 0:$ex=580;$img = Yii::getAlias('@web')."/images/member/putong.png";break;
        case 1:$ex=480;$img = Yii::getAlias('@web')."/images/member/gaoduan.png";break;
        case 2:$ex=380;$img = Yii::getAlias('@web')."/images/member/zhizun.png";break;
        case 3:$ex=280;$img = Yii::getAlias('@web')."/images/member/siren.png";break;
        case 4:$ex=180;$img = Yii::getAlias('@web')."/images/member/siren.png";break;
    }
?>

<div class="row member-upgrade">
    <a class="upgrade-box clearfix" href="single-member-details?id=<?=$item['id']?>">
        <div class="col-xs-3">
            <div class="member-icon">
                <img style="width: 66px;" src="<?=$img?>">
            </div>
        </div>
        <div class="col-xs-7">
            <div style="font-weight:bold;font-size:16px;margin-bottom:5px;"><?=$item['member_name']?></div>
            <p style="color:#B0AEAE;"><?=Helper::truncate_utf8_string($item['member_introduce'], 18);?></p>
        </div>
         <div class="col-xs-2 text-right">
            <span style="font-size:30px;line-height:60px;color:#CAC8C8;" class="glyphicon glyphicon-menu-right"></span>
        </div>
    </a>
</div>
<?php endforeach;?>
