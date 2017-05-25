<?php

use shiyang\webuploader\MultiImage;

$this->title = "上传图片";
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->zid]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Upload');

?>

<?= MultiImage::widget(); ?>

