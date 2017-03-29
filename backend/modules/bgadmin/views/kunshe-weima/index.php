<?php
use yii\helpers\Html;
$this->title = '渠道二维码创建与统计';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCss("
       .table{width:80%;}
    .table thead tr{background-color: #ddd;}
    .table thead tr th{border:1px solid #eee;text-align:center;}
    .table tr td{border:1px solid #eee;text-align:center;}
    .follow{margin-bottom:0;}
    .follow li{list-style: none;}

");
?>
<div class="scan-weima-detail-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('创建渠道二维码', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
<table class="table table-bordered">
    <caption>今日渠道二维码统计</caption>
    <thead>
    <tr>
        <th>渠道名称</th>
        <th>
            <ul class="follow list-group">
                <li>新粉丝</li>
                <li>关注 / 取消</li>
            </ul>
        </th>
        <th>
            <ul class="follow list-group">
                <li>老粉丝</li>
                <li>关注 / 取消</li>
            </ul>
        </th>
        <th>
            <ul class="follow list-group">
                <li>今日总计</li>
                <li>关注 / 取消</li>
            </ul>
        </th>
        <th>今日增长</th>
        <th>数据统计</th>
        <th>二维码</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($model as $item):
        $new_subscribe = empty($item['count']['new_subscribe'])?0:$item['count']['new_subscribe'];
        $old_subscribe = empty($item['count']['old_subscribe'])?0:$item['count']['old_subscribe'];
        $new_unsubscribe = empty($item['count']['new_unsubscribe'])?0:$item['count']['new_unsubscribe'];
        $old_unsubscribe = empty($item['count']['old_unsubscribe'])?0:$item['count']['old_unsubscribe'];
        ?>
        <tr>
            <td><?=$item['customer_service']?></td>
            <td><?=$new_subscribe?> / <?=$new_unsubscribe?></td>
            <td><?=$old_subscribe?> / <?=$old_unsubscribe?></td>
            <td><?=$new_subscribe+$old_subscribe?> / <?=$new_unsubscribe+$old_unsubscribe?></td>
            <td><?=$new_subscribe+$old_subscribe-$new_unsubscribe-$old_unsubscribe?></td>
            <td><a href="#" onclick="window.open('<?=\yii\helpers\Url::to(['tong-ji','sence_id'=>$item['sence_id']])?>','','toolbar=no,status=0,location=no,resizable=yes,menubar=no,scrollbars=yes,top='+(window.screen.availHeight-600)/2+',left='+(window.screen.availWidth-1000)/2+',height=600,width=760')">查看</a></td>
            <td><a data-lightbox="gg" data-title="<?=$item['customer_service']?>" href="<?=$item['remote_path']?>">查看二维码</a></td>
            <td>删除</td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>