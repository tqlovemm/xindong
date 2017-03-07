<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\seek\models\AlipayCoinRechargeRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Alipay Coin Recharge Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alipay-coin-recharge-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // echo Html::a('Create Alipay Coin Recharge Record', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'user_id',
            'user_number',
            'total_fee',
            'giveaway',
            'out_trade_no',
            'subject',
            'notify_time',
            // 'extra:ntext',
            'description',
            // 'day_time:datetime',
            // 'week_time:datetime',
            // 'mouth_time:datetime',
             'type',
             //'status',
             'platform',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
