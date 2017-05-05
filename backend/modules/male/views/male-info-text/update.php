<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\male\models\MaleInfoText */

$this->title = 'Update Male Info Text: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Male Info Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="male-info-text-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
