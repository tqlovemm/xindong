<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\member\models\AlipayCoinRechargeRecord */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Alipay Coin Recharge Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alipay-coin-recharge-record-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'user_id',
            'user_number',
            'total_fee',
            'giveaway',
            'out_trade_no',
            'subject',
            'notify_time',
            'extra:ntext',
            'description',
            'day_time:datetime',
            'week_time:datetime',
            'mouth_time:datetime',
            'type',
            'status',
            'platform',
        ],
    ]) ?>

</div>
