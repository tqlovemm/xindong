<?php
    use yii\widgets\LinkPager;
    use yii\helpers\Html;
    use yii\myhelper\Helper;
    $this->title=Yii::t('app','Feedback');
?>
    <table class="table table-bordered table-hover">
    <tr><!--<th width="150">会员名</th>--><th width="200">反馈时间</th><th width="200">标题</th><th width="500">内容</th><th width="200">操作</th></tr>
<?php
    foreach($feeds as $feed ):

?>
<tr>
    <!--    <td><?/*=$feed['created_by']*/?></td>-->
        <td><?=date('Y-m-d H:i:s',$feed['created_at'])?></td>
        <td><?=Html::encode($feed['title'])?></td>
        <td>
            <?=Helper::truncate_utf8_string(Html::encode($feed['content']),125)?>
        </td>
        <td><?=Html::a('查看','/index.php/site/feedview?id='.$feed['id'],['class'=>'btn btn-success'])?>&nbsp;&nbsp;&nbsp;<?=Html::a('删除','/index.php/site/feeddelete?id='.$feed['id'],['class'=>'btn btn-danger'])?></td>
</tr>
<?php
    endforeach;
?>
    </table>
<?= LinkPager::widget(['pagination' => $pages]); ?>

