<?php
use yii\helpers\Url;
use yii\helpers\Html;

$website = new \backend\modules\exciting\models\OtherText();
$albumUrl = Url::toRoute(['/exciting/other-text/view', 'id' => $model['tid']]);
$src =$website->getCoverPhoto($model['tid']);
?>
<div class="album-img">
    <a class="img-thumbnail" href="<?= $albumUrl ?>">
        <img src="<?= $src ?>" class="album-cover img-responsive" alt="album-cover" style="width: 200px;height: 200px;">
    </a>
	<p style="padding: 5px;background-color: #fff;"><?= Html::a($model['title'], $albumUrl, ['class' => 'album-name']) ?></p>
</div>
