<?php
use yii\widgets\LinkPager;
$items = array();
foreach($model as $item) {

    $order_id = $item['created_at'];
    unset($item['created_at']);
    if(!isset($items[$order_id])) {
        $items[$order_id] = array('order_id'=>$order_id, 'items'=>array());
    }
    $items[$order_id]['items'][] = $item;
}
rsort($items);

?>
<table class="table table-bordered table-striped">
<?php foreach($items as $key=>$val):?>
  <tr>
      <td>时间</td><td><?=date('Y-m-d',$val['order_id'])?></td>
        <?php foreach ($val['items'] as $list):?>
            <td><?php if($list['status']==10){echo '新关注数';}elseif($list['status']==1){echo '取关后又关注数';}else{echo '已关注后扫码数';} ?></td>
            <td><?=$list['count']?></td>
        <?php endforeach;?>
  </tr>
<?php endforeach;?>
</table>

<?= LinkPager::widget(['pagination' => $pages]); ?>