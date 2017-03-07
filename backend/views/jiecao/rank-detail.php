<?php
    use yii\widgets\LinkPager;
?>
<div class="row" style="border-radius: 10px;">
    <?php foreach ($model as $key=>$list):
        if($list['type']==2){
            $type = "节操币充值";
        }elseif($list['type']==3){
            $type = "会员升级";
        }else{
            $type = "十七平台会员开通地区";
        }
    if($key==0):?>
    <div style="padding:10px 20px;">
        <h4>会员ID：<?=$list['user_id']?></h4>
        <h4>会员编号：<?=\backend\models\User::getNumber($list['user_id'])?></h4>
    </div>
    <?php endif;?>
    <div class="col-md-4">
        <div class="row" style="background-color: #fff;margin: 0 0 10px 0;padding: 10px;">
        <div style="padding: 5px 5px;"><span style="background-color: #0ad425;color:#fff;padding:2px 6px;border-radius: 50%;"><?=$key+1?></span> 时间：<?=date('Y-m-d H:i:s',$list['created_at'])?></div>
        <div style="border-top: 1px dotted #ddd;padding: 5px 5px;">
            <?=$type?>；充值金额：<?=$list['total_fee']?>；赠送节操币：<?=$list['giveaway']?></div>
        </div>
    </div>
    <?php endforeach;?>
    <?= LinkPager::widget(['pagination' => $pages]); ?>
</div>

