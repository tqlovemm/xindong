<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\seek\models\Seek;

$albumUrl = Url::toRoute(['/seek/attribute/view', 'id' => $model['id']]);
$src = Seek::getCoverPhoto($model['id'], $model['cover_id']);
$name = Html::encode($model['name']);
$status = ($model['status'] != Seek::TYPE_PUBLIC) ? '<i class="glyphicon glyphicon-lock"></i>' : '';
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
			<?= Html::a($name, $albumUrl, ['class' => 'album-name']) ?>
		</div>
	</div>
</div>
