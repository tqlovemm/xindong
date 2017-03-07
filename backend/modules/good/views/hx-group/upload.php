<?php
use shiyang\webuploader\MultiImage;

$this->title = "上传组群的头像（限上传一个）";
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Upload');
?>
<?= MultiImage::widget(); ?>