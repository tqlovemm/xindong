<?php

use yii\helpers\Html;
use yii\helpers\Url;
use shiyang\webuploader\MultiImage;

$this->title = '上传';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->text_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Upload');

?>

<?= MultiImage::widget(); ?>

