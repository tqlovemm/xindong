<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\recharge\models\Recharge;
use yii\myhelper\Helper;
$recharge = new Recharge();

$albumUrl = Url::toRoute(['/recharge/recharge/view', 'id' => $model['id']]);
/*$src =$recharge->getCoverPhoto($model['id'], $model['cover_id']);*/
$name = Html::encode($model['title']);
$status = ($model['status'] != Recharge::TYPE_PUBLIC) ? '<i class="glyphicon glyphicon-lock"></i>' : '';
?>
<div class="album-img" style="position: relative;">
    <a href="<?= $albumUrl ?>">
        <img src="<?= $model['avatar'] ?>" class="album-cover img-thumbnail img-responsive center-block" alt="album-cover" style="width: 100px;height: 120px;">
		<?php if($model['cover_id']==-1):?>
    	<span style="position: absolute;top:40%;left:20%;background-color: rgba(255, 0, 0, 0.51);padding:10px;border-radius: 50%;color:white;">已隐藏</span>
		<?php endif;?>
	</a>

</div>
<div class="album-info">
	<div class="album-desc">
		<div class="album-desc-side"><?= $status ?></div>
		<div class="album-tit">
			<?= Html::a(Helper::truncate_utf8_string($name,10), $albumUrl, ['class' => 'album-name','title'=>$name]) ?>
			&nbsp;&nbsp;<a class="recharge-hide" style="padding:5px;cursor: pointer;" data-id="<?=$model['id']?>" onclick="recharge_toggle(<?=$model['id']?>,this)"><?php if($model['cover_id']==0):?>隐<?php else:?>显<?php endif;?>
			</a>
			<a class="pull-right text-red" href="<?= Url::to(['/recharge/recharge/delete', 'id' => $model['id']]) ?>" data-method="post" data-confirm="确定删除吗">删除</a>
		</div>
	</div>
</div>



