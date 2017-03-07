<?php

use shiyang\webuploader\MultiImage;

$this->title = $model->pid;
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->pid]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Upload');

?>

<?= MultiImage::widget(); ?>

