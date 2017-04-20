<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\financial\models\FinancialWechatMemberIncreaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Financial Wechat Member Increases';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="financial-wechat-member-increase-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Create Financial Wechat Member Increase', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'wechat_id',
            'increase_boy_count',
            'increase_girl_count',
            'total_count',
            'reduce_count',
            'created_at:date',
            'created_by',
            'loose_change',
            'join_count',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
