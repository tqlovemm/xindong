<?php
    use yii\helpers\Html;
    $this->title = "app节操币消费统计";
?>
<p>
    <?= Html::a('会员充值统计', ['static'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('图形统计', ['statistical-chart'], ['class' => 'btn btn-success']) ?>
</p>
<div class="static-index">
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered">
                <caption>总计</caption>
                <tr style="background-color: #E8C9ED;"><th>序号</th><th>总计</th><th>单数</th><th>时间</th></tr>
                <?php foreach ($model_4 as $key=>$item):?>
                    <tr class="success"><td><?=$key+1?></td><td><?=$item['t']?>元</td><td><?=$item['n']?>笔</td><td>从 <?=date('Y年m月d日',$item['min'])?> 到 <?=date('Y年m月d日',$item['max'])?></td></tr>
                <?php endforeach;?>
            </table>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered">
                <caption>类型统计</caption>
                <tr class="danger"><th>序号</th><th>类型</th><th>总金额</th><th>单数</th><th>时间</th></tr>
                <?php foreach ($model_1 as $key=>$item):
                    $typeText = ($item['type'])==1?'节操币充值':'会员升级';
                    ?>
                    <tr class="success"><td><?=$key+1?></td><td><?=$typeText?></td><td><?=$item['t']?>元</td><td><?=$item['n']?>笔</td><td>从 <?=date('Y年m月d日',$item['min'])?> 到 <?=date('Y年m月d日',$item['max'])?></td></tr>
                <?php endforeach;?>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered">
                <caption>渠道统计</caption>
                <tr class="danger"><th>序号</th><th>渠道</th><th>总计</th><th>单数</th><th>时间</th></tr>
                <?php foreach ($model_5 as $key=>$item):?>
                    <tr class="success">
                        <td><?=$key+1?></td><td><?=$item['channel']?></td><td><?=$item['t']?>元</td><td><?=$item['n']?>笔</td><td>从 <?=date('Y年m月d日',$item['min'])?> 到 <?=date('Y年m月d日',$item['max'])?></td>
                   </tr>
                <?php endforeach;?>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6" style="height: 800px;overflow:auto;">
            <table class="table table-bordered">
                <caption>每月统计</caption>
                <tr class="warning"><th>序号</th><th>月时间</th><th>总金额</th><th>单数</th><th>时间</th></tr>
                <?php foreach ($model_3 as $key=>$item):
                    $mouth_num = date('m',$item['w']);
                    if($mouth_num==0){
                        $mouth_num = 12;
                    }
                    $mouth_txt = date('Y',$item['w']).'年'.$mouth_num.'月';
                    ?>
                    <tr class="success"><td><?=$key+1?></td><td><?=$mouth_txt?></td><td><?=$item['t']?>元</td><td><?=$item['n']?>笔</td><td>从 <?=date('Y年m月d日',$item['min'])?> 到 <?=date('Y年m月d日',$item['max'])?></td></tr>
                <?php endforeach;?>
            </table>
            <table class="table table-bordered">
                <caption>每周统计</caption>
                <tr class="warning"><th>序号</th><th>周时间</th><th>总金额</th><th>单数</th><th>时间</th></tr>
                <?php foreach ($model_2 as $key=>$item):?>
                    <tr class="success"><td><?=$key+1?></td><td>第<?=date('W',$item['w'])?>周</td><td><?=$item['t']?>元</td><td><?=$item['n']?>笔</td><td>从 <?=date('Y年m月d日',$item['min'])?> 到 <?=date('Y年m月d日',$item['max'])?></td></tr>
                <?php endforeach;?>
            </table>
        </div>
        <div class="col-md-6"  style="height: 800px;overflow:auto;">
            <table class="table table-bordered">
                <caption>每日统计</caption>
                <tr class="warning"><th>序号</th><th>时间</th><th>总金额</th><th>单数</th></tr>
                <?php foreach ($model_6 as $key=>$item):?>
                    <tr class="success"><td><?=$key+1?></td><td><?=date('Y-m-d',$item['c'])?></td><td><?=$item['t']?>元</td><td><?=$item['n']?>笔</td></tr>
                <?php endforeach;?>
            </table>
        </div>

    </div>
</div>
