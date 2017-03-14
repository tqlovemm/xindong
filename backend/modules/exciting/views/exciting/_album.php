<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\exciting\models\Exciting;
$exciting = new Exciting();

$albumUrl = Url::toRoute(['/exciting/exciting/view', 'id' => $model['id']]);
$src =$exciting->getCoverPhoto($model['id'], $model['cover_id']);
$name = $model['title']==1?'女生反馈':'男生反馈';
$content = Html::encode($model['content']);
$status = ($model['status'] != Exciting::TYPE_PUBLIC) ? '<i class="glyphicon glyphicon-lock"></i>' : '';
$pre_url = Yii::$app->params['threadimg'];
?>
<div class="album-img">

    <a class="img-thumbnail" href="<?= $albumUrl ?>">
        <img src="<?= $pre_url.$src ?>" class="album-cover img-responsive" alt="album-cover" style="width: 100px;height: 100px;">
    </a>

</div>
<div class="album-info">
	<div class="album-desc">
		<div class="album-desc-side"><?= $status ?></div>
		<div class="album-tit">
			<?= Html::a($name, $albumUrl, ['class' => 'album-name']) ?>
			<a class="pull-right" data-method="post" data-confirm="确定删除吗" href="<?=Url::to(['/exciting/exciting/delete', 'id' => $model['id']])?>">删除</a>
		</div>
	</div>
</div>
