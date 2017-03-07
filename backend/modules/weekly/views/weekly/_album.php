<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\weekly\models\Weekly;
use yii\myhelper\Helper;
$weekly = new Weekly();

$albumUrl = Url::toRoute(['/weekly/weekly/view', 'id' => $model['id']]);
$src =$weekly->getCoverPhoto($model['id'], $model['cover_id']);
$name = Html::encode($model['title']);
$status = ($model['status'] != Weekly::TYPE_PUBLIC) ? '<i class="glyphicon glyphicon-lock"></i>' : '';
?>
<div class="album-img">
    <a href="<?= $albumUrl ?>">
        <img src="<?= $src ?>" class="album-cover" alt="album-cover" style="width: 200px;">
    </a>
</div>
<div class="album-info">
	<div class="album-desc">
		<div class="album-desc-side"><?= $status ?></div>
		<div class="album-tit">
			<?= Html::a(Helper::truncate_utf8_string($name,10), $albumUrl, ['class' => 'album-name','title'=>$name]) ?>
			<a class="pull-right text-red" href="<?= Url::to(['/weekly/weekly/delete', 'id' => $model['id']]) ?>" data-method="post" data-confirm="确定删除吗">删除</a>
		</div>
	</div>
</div>
