<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\note\models\Note;
$note = new Note();

$albumUrl = Url::toRoute(['/note/note/view', 'id' => $model['id']]);
$src =$note->getCoverPhoto($model['id'], $model['cover_id']);
$name = $model['title'];
$content = Html::encode($model['content']);
$status = ($model['status'] != Note::TYPE_PUBLIC) ? '<i class="glyphicon glyphicon-lock"></i>' : '';
?>
<div class="album-img">
    <a class="img-thumbnail" href="<?= $albumUrl ?>">
        <img src="<?= $src ?>" class="album-cover img-responsive" alt="album-cover" style="width: 100px;height: 100px;">
    </a>
</div>
<div class="album-info">
	<div class="album-desc">
		<div class="album-tit">
			<?= Html::a($name, $albumUrl, ['class' => 'album-name']) ?>
			<a class="pull-right" data-method="post" data-confirm="确定删除吗" href="<?=Url::to(['/note/note/delete', 'id' => $model['id']])?>">删除</a>
		</div>
	</div>
</div>
