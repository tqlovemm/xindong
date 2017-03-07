<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\seek\models\ServicePatters */

$this->title = 'Update Service Patters: ' . ' ' . $model->pid;
$this->params['breadcrumbs'][] = ['label' => 'Service Patters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pid, 'url' => ['view', 'id' => $model->pid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="service-patters-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
