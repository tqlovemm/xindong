<?php


use yii\widgets\LinkPager;
    $this->registerCss("
    
        .col-xs-9,.col-xs-2,.col-xs-3,.col-xs-4,.col-xs-5,.col-xs-6{padding:0;}
        .row{background-color:#fff;}
        .border{border-top:1px solid gray;border-bottom:1px solid gray;border-left:1px solid gray;text-align:center;}
        .border1{border-bottom:1px solid gray;border-left:1px solid gray;text-align:center;}
        .border2{border-right:1px solid gray;}
    ");?>
    <div class="row navbar-fixed-top" style="background-color: red;color:#fff;padding:10px;margin-left:0;">
    <?php

    $total = 0;
    $sum = 0;
    $success = 0;
    foreach ($result_count as $item):

            if($item['status']==9){
                $result = "转交等待";
            }elseif($item['status']==10){
                $result = "客服等待";
            }elseif($item['status']==11){
                $result = "觅约成功";
            }else{
                $result = "觅约失败";
            }
        $total += $item['total'];
        if($item['status']==11||$item['status']==12){

            $sum += $item['total'];
        }
        if($item['status']==11){

            $success+= $item['total'];
        }
        ?>

        <div class="col-xs-2">
            <?=$result?>:<?=$item['total']?>
        </div>
    <?php endforeach;?>
        <div class="col-xs-2">
            <?php if($sum!=0):?>
                成功率:<?=round($success/$sum,3)*100?>%
            <?php else:?>
                0
            <?php endif;?>
        </div>
        <div class="col-xs-2">总计：<?=$total?></div>
    </div>
<div class="clearfix" style="margin-top: 100px;">


<?php
    $add = array();
    foreach($model as $key=>$val):

        if($val['status']==10||$val['status']==9){
            $result = "觅约等待中";
        }elseif ($val['status']==11){
            $result = "觅约成功";
        }elseif ($val['status']==12){
            $result = "觅约失败";
        }

        $like_info = json_decode($val['extra'],true);
        array_push($add, $like_info['address'])
    ?>

    <div class="row" style="margin-bottom: 10px;padding:10px;">
        <div class="col-xs-2 border">ID</div>
        <div class="col-xs-3 border">时间</div>
        <div class="col-xs-2 border">金额</div>
        <div class="col-xs-2 border">结果</div>
        <div class="col-xs-3 border border2">处理人</div>

        <div class="col-xs-2 border1"><?=$val['user_id']?></div>
        <div class="col-xs-3 border1"><?=date('Y-m-d H:i',$val['updated_at'])?></div>
        <div class="col-xs-2 border1"><?=$val['number']?></div>
        <div class="col-xs-2 border1"><?=$result?></div>
        <div class="col-xs-3 border1 border2">&nbsp;<?=$val['handler']?></div>
        <hr>
        <div class="col-xs-3">
            <img style="width: 100px;" src="<?=$like_info['avatar']?>">
        </div>
        <div class="col-xs-7" style="padding: 0;">
            <h6>编号：<?=$like_info['number']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价格：<?=$like_info['worth']?></h6>
            <h6>标签：<?=$like_info['mark']?></h6>
            <h6>交友要求：<?=$like_info['require']?></h6>
            <h6>简述：<?=$like_info['introduction']?></h6>
        </div>
        <?php if($val['status']==11):?>
        <div class="col-xs-2" style="line-height: 100px;">
            <a  data-confirm="确认撤销吗？撤销后将退还会员所有节操币！" href="dating-success-dropped?id=<?=$val['id']?>" class="btn btn-primary">撤销</a>
        </div>
        <?php endif;?>
        <div class="col-xs-12"><strong>处理原因：</strong><?=$val['reason']?></div>

    </div>

    <?php endforeach;?>

<div class="row navbar-fixed-top" style="background-color:orange;color:#fff;padding:10px;top:40px;margin-left:0;">
<div class="col-xs-2">地区统计：</div>
<?php foreach (array_count_values($add) as $key => $value):?>
    <div class="col-xs-1" style="padding:0;width:10%;"><?=$key?>:<?=$value?></div>
<?php endforeach;?>
</div>
<?= LinkPager::widget(['pagination' => $pages]); ?>
</div>
