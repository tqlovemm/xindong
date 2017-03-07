<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\flop\models\Flop;
$flop = new Flop();
	$flopUrl = Url::toRoute(['/flop/flop/view', 'id' => $model['id']]);
/*	$src =$flop->getCoverPhoto($model['id'], $model['cover_id']);*/
	$name = $model['area'];

?>
<!--<div class="flop-img">
    <a href="<?/*= $flopUrl */?>">
        <img src="<?/*= $src */?>" class="flop-cover img-responsive" alt="flop-cover" style="width: 150px;height: 200px;">
    </a>
</div>-->
<div class="flop-info" style="margin: 5px;border:1px solid #c4c4c4;padding:5px;border-radius: 5px;">
	<div class="flop-desc">
		<div class="flop-tit">
			<?= Html::a($name, $flopUrl, ['class' => 'flop-name btn btn-primary']) ?>
			<a style="margin-left: 5px;" class="pull-right btn btn-default" data-method="post" data-confirm="确定删除吗" href="<?=Url::to(['/flop/flop/delete', 'id' => $model['id']])?>">删除</a>
		</div>
	</div>
</div>
