<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\bgadmin\models\ScanWeimaDetail */

$this->title = 'Update Scan Weima Detail: ' . ' ' . $model->sence_id;
$this->params['breadcrumbs'][] = ['label' => 'Scan Weima Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sence_id, 'url' => ['view', 'id' => $model->sence_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="scan-weima-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
