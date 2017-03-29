<?php
use yii\widgets\LinkPager;
$this->title = "渠道粉丝数据统计";
$this->registerCss("
    .table{width:100%;}
    .table thead tr{background-color: #ddd;}
    .table thead tr th{border:1px solid #eee;text-align:center;}
    .table tr td{border:1px solid #eee;text-align:center;}
    .follow{margin-bottom:0;}
    .follow li{list-style: none;}
    .skin-blue-light .main-header .logo{display:none;}
    
    .weimenubox li.on, .weimenubox li.on a {
    background: #d7d7d7;
    color: #333;
    display: block;
}
.weimenubox li {
    float: left;
    height: 30px;
    line-height: 30px;
    border-top: 1px #c9cace solid;
    border-bottom: 1px #c9cace solid;
    border-right: 1px #c9cace solid;
    font-size: 14px;
}
.weimenubox li a {
    padding: 0 25px;
    line-height: 30px;
    height: 30px;
    color: #333;
    text-decoration: none;
    display: block;
}
    .weimenubox {
    margin-bottom: 10px;
    border-left: 1px #c9cace solid;
    
}
");
?>
<div style="width:740px;margin:0 auto;height:40px;line-height:40px;text-align:center;">
    <div class="weimenubox">
        <ul class="list-group">
            <li class="on"><a href="">渠道粉丝数据统计</a></li>
            <li><a href="<?=\yii\helpers\Url::to(['fen-si','sence_id'=>$model[0]['sence_id']])?>">渠道粉丝明细</a></li>
            <div class="clearfix"></div>
        </ul>
    </div>
</div>
<table class="table table-bordered table-striped">
    <caption><?=$model[0]['wm']['customer_service']?>：历史数据总计</caption>
    <thead>
    <tr>
        <th rowspan="2" style="line-height: 54px;">日期</th>
        <th colspan="2">新粉丝</th>
        <th colspan="2">老粉丝</th>
        <th colspan="2">总计</th>
        <th rowspan="2" style="line-height: 54px;">增长</th>
    </tr>
    <tr>
        <th>关注</th><th>取消</th>
        <th>关注</th><th>取消</th>
        <th>关注</th><th>取消</th>
    </tr>
    </thead>
    <tr>
        <td>历史统计</td>
        <td><?=$count[0]['new_subscribe']?></td><td><?=$count[0]['new_unsubscribe']?></td>
        <td><?=$count[0]['old_subscribe']?></td><td><?=$count[0]['old_unsubscribe']?></td>
        <td><?=$count[0]['new_subscribe']+$count[0]['old_subscribe']?></td><td><?=$count[0]['new_unsubscribe']+$count[0]['old_unsubscribe']?></td>
        <td><?=$count[0]['new_subscribe']+$count[0]['old_subscribe']-$count[0]['new_unsubscribe']-$count[0]['old_unsubscribe']?></td>
    </tr>

</table>
    <table class="table table-bordered table-striped">
    <caption><?=$model[0]['wm']['customer_service']?>：渠道二维码每日统计</caption>
    <thead>
    <tr>
        <th rowspan="2" style="line-height: 54px;">日期</th>
        <th colspan="2">新粉丝</th>
        <th colspan="2">老粉丝</th>
        <th colspan="2">当日总计</th>
        <th rowspan="2" style="line-height: 54px;">当日增长</th>
    </tr>
    <tr>
        <th>关注</th><th>取消</th>
        <th>关注</th><th>取消</th>
        <th>关注</th><th>取消</th>
    </tr>
    </thead>
<?php foreach($model as $key=>$item):?>
    <tr>
        <td><?=date('Y-m-d',$item['created_at'])?></td>
        <td><?=$item['new_subscribe']?></td><td><?=$item['new_unsubscribe']?></td>
        <td><?=$item['old_subscribe']?></td><td><?=$item['old_unsubscribe']?></td>
        <td><?=$item['new_subscribe']+$item['old_subscribe']?></td><td><?=$item['new_unsubscribe']+$item['old_unsubscribe']?></td>
        <td><?=$item['new_subscribe']+$item['old_subscribe']-$item['new_unsubscribe']-$item['old_unsubscribe']?></td>
    </tr>
<?php endforeach;?>
</table>

<?= LinkPager::widget(['pagination' => $pages]); ?>