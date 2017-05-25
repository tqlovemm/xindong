<?php

$this->title = "上传图片";
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Upload');

?>

<?=\shiyang\webuploader\MultiImage::widget(); ?>

