<?php
use shiyang\masonry\Masonry;
$this->title = "明细";
$this->registerCss("

    .purchase-history{padding:10px 10px;background-color:#fff;border-bottom:1px solid #F2F2F2;}
    .purchase-history-box{background-color:#fff;padding:10px;box-shadow: 0 0 3px #D5D3D3;border-radius:5px;font-size:12px;}
    .purchase-history-box hr{margin:15px 0;}
    .purchase-history-box p{font-size: 12px;}
    li{list-style: none;}
");

?>

<link rel="stylesheet" href="<?=Yii::getAlias("@web")?>/js/more/pullToRefresh.css" />
<script src="<?=Yii::getAlias("@web")?>/js/more/iscroll.js"></script>
<script src="<?=Yii::getAlias("@web")?>/js/more/pullToRefresh.js"></script>
<div class="row member-center">
    <header>
        <div class="header">
            <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
            <h2 style="margin:0;"><?=$this->title?></h2>
        </div>
    </header>
</div>
<div id="wrappers" class="row">
    <ul class="list-group">
    <?php Masonry::begin([
        'options' => [
            'id' => 'photos'
        ],
        'pagination' => $pages
    ]); ?>

    <?php foreach ($photos as $item):
        $today = strtotime('today');
        $one = 86400;

        if($item['created_at']-$today==0){
            $time = "今天";
        }elseif($today-$item['created_at']==$one){

            $time = "昨天";
        }elseif($today-$item['created_at']==2*$one){

            $time = "前天";
        }else{
            $time = date('m/d',$today-$item['created_at']);

        }
        if($item['subject']==1){

            $pay = '+'.$item['number'];
            $img = Yii::getAlias("@web")."/images/member/wallet.png";
            $msg = "节操币充值";

        }elseif($item['subject']==3){

            $pay = -$item['number'];
            $extra = json_decode($item['extra'],true);
            $img = $extra['avatar'];
            $msg = "求推荐{$extra['address']}妹子：{$extra['number']}";

        }elseif(in_array($item['subject'],[4])){

            $pay = '+'.($item['number']+$item['giveaway']);
            $img = Yii::getAlias("@web")."/images/member/wallet.png";
            $msg = "寻约失败退款";

        }elseif($item['subject']==2){

            $notice_title = "会员升级通知";
            $notice_content = "恭喜您升级$item[type]成功";
            $pay = $item['number'];

        }

        ?>
        <li class="purchase-history list-group-item" style="width: 100%;" data-id="<?=$item['id']?>">
            <div class="col-xs-2 timeline" style="padding: 0;font-size: 18px;color:#bababa;line-height: 45px;">
                <?=$time?>
            </div>
            <div class="col-xs-2 img-user-avatar" style="padding: 0;">
                <img style="width: 45px;border-radius: 50%;" class="img-responsive center-block" src="<?=$img?>">
            </div>
            <div class="col-xs-8 info-box" style="padding-right:0;">
                <h4 style="margin-top: 0;font-weight: 600;">
                    <?=$pay?>

                    <?php if($item['giveaway']!=0):?>
                        &nbsp;&nbsp;&nbsp;赠&nbsp;&nbsp;+<?=$item['giveaway']?>
                    <?php endif;?>
                    <?php if(!empty($item['refund'])):?>
                        &nbsp;&nbsp;&nbsp;返&nbsp;&nbsp;+<?=$item['refund']?>
                    <?php endif;?>
                </h4>
                <h6 style="margin: 5px 0 0;"><?=$msg?></h6>
            </div>
        </li>
    <?php endforeach ?>

    <?php Masonry::end();return;?>
    </ul>
</div>
