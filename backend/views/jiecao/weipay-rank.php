<?php
use yii\widgets\LinkPager;

?>
<table class="table table-bordered table-striped">
    <tr>
        <td>会员ID</td>
        <td>会员编号</td>
        <td>充值总金额</td>
        <td>充值次数</td>
        <td>查看详情</td>
    </tr>
    <?php foreach($model as $key=>$val):
        $number = \backend\models\User::getNumber($val['user_id']);
        ?>
        <tr>
            <td><?=$val['user_id']?></td>
            <td><?=$number?></td>
            <td><?=$val['fee']?></td>
            <td><?=$val['count']?></td>
            <td><a href="rank-detail?user_id=<?=$val['user_id']?>" class="btn btn-warning">进入</a></td>
        </tr>

    <?php endforeach;?>
</table>
<?= LinkPager::widget(['pagination' => $pages]); ?>