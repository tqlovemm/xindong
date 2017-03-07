<?php

use yii\helpers\Html;
use yii\helpers\Url;
use shiyang\webuploader\MultiImage;

$this->title = '心动周刊';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Upload');

?>

<?= MultiImage::widget(); ?>

