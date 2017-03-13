<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\dating\models\Dating;
use yii\myhelper\Helper;
$dating = new Dating();

$albumUrl = Url::toRoute(['/dating/dating/view', 'id' => $model['id']]);
/*$src =$dating->getCoverPhoto($model['id'], $model['cover_id']);*/
$name = Html::encode($model['title']);
$status = ($model['status'] != Dating::TYPE_PUBLIC) ? '<i class="glyphicon glyphicon-lock"></i>' : '';
$pre_url = Yii::$app->params['shisangirl'];
?>
<div class="album-img" style="position: relative;">
    <a href="<?= $albumUrl ?>">
        <img src="<?= $pre_url.$model['avatar'] ?>" class="album-cover img-thumbnail img-responsive center-block" alt="album-cover" style="width: 100px;height: 120px;">
		<?php if($model['cover_id']==-1):?>
    	<span style="position: absolute;top:40%;left:20%;background-color: rgba(255, 0, 0, 0.51);padding:10px;border-radius: 50%;color:white;">已隐藏</span>
		<?php elseif($model['cover_id']==-2):?>
			<?php if($model['platform']==0):?>
				<span style="position: absolute;top:20%;left:0;background-color: rgba(0, 0, 255, 0.56);padding:5px;color:white;">跟踪列表传来,女生照片公开</span>
			<?php else:?>
				<span style="position: absolute;top:20%;left:0;background-color: rgba(0, 0, 255, 0.56);padding:5px;color:#ff5459;">跟踪列表传来,女生要求照片打码</span>
			<?php endif;?>

		<?php endif;?>
	</a>

</div>
<div class="album-info">
	<div class="album-desc">
		<div class="album-desc-side"><?= $status ?></div>
		<div class="album-tit">
			<?= Html::a(Helper::truncate_utf8_string($name,10), $albumUrl, ['class' => 'album-name','title'=>$name]) ?>
			<?php if($model['cover_id']!=-2):?>
			&nbsp;&nbsp;<a class="dating-hide" style="padding:5px;cursor: pointer;" data-id="<?=$model['id']?>" onclick="dating_toggle(<?=$model['id']?>,this)"><?php if($model['cover_id']==0):?>隐<?php else:?>显<?php endif;?>
			</a>
			<?php endif;?>
			<a class="pull-right text-red" href="<?= Url::to(['/dating/dating/delete', 'id' => $model['id']]) ?>" data-method="post" data-confirm="确定删除吗">删除</a>
		</div>
	</div>
</div>



