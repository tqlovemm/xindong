<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\dating\models\HeartWeek;
use yii\myhelper\Helper;
$heart = new HeartWeek();

$albumUrl = Url::toRoute(['/dating/heart-week/view', 'id' => $model['id']]);

$name = Html::encode($model['title']);
$status = ($model['status'] != HeartWeek::TYPE_PUBLIC) ? '<i class="glyphicon glyphicon-lock"></i>' : '';
?>
<div class="album-img" style="position: relative;">
    <a href="<?= $albumUrl ?>">
        <img src="<?= $model['avatar'] ?>" class="album-cover img-thumbnail img-responsive center-block" alt="album-cover" style="width: 100px;height: 120px;">

	</a>

</div>
<div class="album-info">
	<div class="album-desc">
		<div class="album-desc-side"><?= $status ?></div>
		<div class="album-tit">
			<?= Html::a(Helper::truncate_utf8_string($name,10), $albumUrl, ['class' => 'album-name','title'=>$name]) ?>
			&nbsp;&nbsp;
			<a class="pull-right text-red" href="<?= Url::to(['/dating/heart-week/delete', 'id' => $model['id']]) ?>" data-method="post" data-confirm="确定删除吗">删除</a>
		</div>
	</div>
</div>



