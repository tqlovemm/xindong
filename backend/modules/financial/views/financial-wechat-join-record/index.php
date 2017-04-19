<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\financial\models\FinancialWechatJoinRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Financial Wechat Join Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="financial-wechat-join-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Financial Wechat Join Record', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'wechat_id',
            'join_source',
            'created_at',
            'updated_at',
            // 'day_time:datetime',
            // 'weekly_time:datetime',
            // 'mouth_time:datetime',
            // 'created_by',
            // 'channel',
            // 'payment_amount',
            // 'vip',
            // 'join_address',
            // 'remarks',
            // 'type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
