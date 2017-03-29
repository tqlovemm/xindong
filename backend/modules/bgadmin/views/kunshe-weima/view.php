<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\bgadmin\models\ScanWeimaDetail */

$this->title = $model->sence_id;
$this->params['breadcrumbs'][] = ['label' => 'Scan Weima Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scan-weima-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->sence_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('统计', ['tj', 'id' => $model->sence_id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->sence_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sence_id',
            'customer_service',
            'account_manager',
            'description',
            'local_path',
            'remote_path:image',
        ],
    ]) ?>

</div>
