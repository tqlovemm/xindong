<?php
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\myhelper\Helper;
$this->title=Yii::t('app','Claims');
?>
    <table class="table table-bordered table-hover">
        <tr><th width="150">会员名</th><th width="200">投诉时间</th><th width="200">投诉对象</th><th width="200">投诉原因</th><th width="400">投诉内容</th><th width="200">附件</th><th width="200">操作</th></tr>
        <?php
        foreach($claims as $claim ):
            ?>
            <tr>
                <td><?=$claim['created_by']?></td>
                <td><?=date('Y-m-d H:i:s',$claim['created_at'])?></td>
                <td><?=$claim['claims_to']?></td>
                <td><?=Html::encode($claim['title'])?></td>
                <td>
                    <?=Helper::truncate_utf8_string(Html::encode($claim['content']),125)?>
                </td>
                <td><img src="<?='/uploads/claims/'.$claim['file']?>" width="200" height="200"></td>
                <td><?=Html::a('查看','/index.php/site/claimsview?id='.$claim['id'],['class'=>'btn btn-success'])?>&nbsp;&nbsp;&nbsp;<?=Html::a('删除','/index.php/site/claimsdelete?id='.$claim['id'],['class'=>'btn btn-danger'])?></td>
            </tr>
            <?php
        endforeach;
        ?>
    </table>
<?= LinkPager::widget(['pagination' => $pages]); ?>