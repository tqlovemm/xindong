<?php
use shiyang\webuploader\MultiImage;
$this->title = "会员等级";
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Upload');
?>
<?= MultiImage::widget(); ?>

