<?php
use shiyang\webuploader\MultiImage;

$this->title = "上传参赛照";
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Upload');
?>
<?= MultiImage::widget(); ?>