<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\financial\models\FinancialWechatJoinRecord */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Financial Wechat Join Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="financial-wechat-join-record-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id, 'wechat_id' => $model->wechat_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id, 'wechat_id' => $model->wechat_id], [
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
            'id',
            'wechat_id',
            'join_source',
            'created_at',
            'updated_at',
            'day_time:datetime',
            'weekly_time:datetime',
            'mouth_time:datetime',
            'created_by',
            'channel',
            'payment_amount',
            'vip',
            'join_address',
            'remarks',
            'type',
        ],
    ]) ?>

</div>
