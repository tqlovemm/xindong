<?php
$page_total = 0;
use yii\widgets\LinkPager;
?>
<div class="row">
    <h1 style="background-color: #ffa459;color:#fff;" class="text-center">历史总计消费：<?=$total?></h1>
    <h1 style="background-color: #ff7b76;color:#fff;" class="text-center">未消费节操币：<?=$save_coin?></h1>
    <div class="col-md-4" style="background-color: #bbc6dc;">
        <h1>按日统计</h1>
        <div class="row" style="padding: 10px;border-bottom: 1px solid #ddd;">
            <div class="col-md-6">
                时间
            </div>
            <div class="col-md-6">
                消费节操币
            </div>
        </div>
        <?php foreach ($model1 as $list):
            $page_total += $list['sum'];
            ?>

            <div class="row" style="padding: 10px;border-bottom: 1px solid #ddd;">
                <div class="col-md-6">
                    <?=date('Y年m月d日',$list['created_at'])?>
                </div>
                <div class="col-md-6">
                    <?=$list['sum']?>
                </div>
            </div>

        <?php endforeach;?>

        <h1 class="text-right">本页总计消费：<?=$page_total?></h1>
        <?= LinkPager::widget(['pagination' => $pages1]); ?>
    </div>
    <div class="col-md-4" style="background-color: beige;">
        <h1>按周统计</h1>
        <div class="row" style="padding: 10px;border-bottom: 1px solid #ddd;">
            <div class="col-md-6">
                时间
            </div>
            <div class="col-md-6">
                消费节操币
            </div>
        </div>
        <?php foreach ($model2 as $key=>$list):
                if($key==0){
                    $week = "本周";
                }elseif($key==1){
                    $week = "上周";
                }else{

                    $week = "第".(count($model2)-$key)."周";
                }
            ?>

            <div class="row" style="padding: 10px;border-bottom: 1px solid #ddd;">
                <div class="col-md-6">
                    <?=$week?>
                </div>
                <div class="col-md-6">
                    <?=$list['sum']?>
                </div>
            </div>

        <?php endforeach;?>
        <?= LinkPager::widget(['pagination' => $pages2]); ?>
    </div>
    <div class="col-md-4" style="background-color: #ffd4cd;">
        <h1>按月统计</h1>
        <div class="row" style="padding: 10px;border-bottom: 1px solid #ddd;">
            <div class="col-md-6">
                时间
            </div>
            <div class="col-md-6">
                消费节操币
            </div>
        </div>
        <?php foreach ($model3 as $key=>$list):

            if($key==0){
                $mouth = "本月";
            }elseif($key==1){
                $mouth = "上月";
            }else{

                $mouth = "第".(count($model3)-$key)."月";
            }
            ?>

            <div class="row" style="padding: 10px;border-bottom: 1px solid #ddd;">
                <div class="col-md-6">
                    <?=$mouth?>
                </div>
                <div class="col-md-6">
                    <?=$list['sum']?>
                </div>
            </div>

        <?php endforeach;?>
        <?= LinkPager::widget(['pagination' => $pages3]); ?>
    </div>

</div>

