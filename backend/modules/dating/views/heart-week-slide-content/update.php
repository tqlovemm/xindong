<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\dating\models\HeartWeekSlideContent */

$this->title = '心动轮播: ' . ' ' .$this->title =Html::encode(strip_tags( $model->name));;
$this->params['breadcrumbs'][] = ['label' => '心动轮播', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="heartweek-slide-content-update">

    <h1><?= $this->title ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
