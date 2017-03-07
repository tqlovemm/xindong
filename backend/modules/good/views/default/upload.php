<?php
use shiyang\webuploader\MultiImage;

$this->title = "爆料图片";
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->tid]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Upload');
?>
<?= MultiImage::widget(); ?>