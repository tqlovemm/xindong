<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\app\models\AppOrderListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'App Order Lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-order-list-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create App Order List', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'order_number',
            'alipay_order',
            'total_fee',
             'giveaway',
             //'subject',
            // 'extra:ntext',
             'channel',
             'description',
            // 'type',
            // 'status',
            [
                'attribute'=>'updated_at',
                'label' => '日期',
                'value' =>  function($data){
                    return date('Y-m-d H:i:s',$data->updated_at);
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
