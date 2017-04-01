<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\setting\models\PredefinedJiecaoCoinSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '固定充值节操币';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="predefined-jiecao-coin-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建固定充值节操币', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'money',
            'giveaway',
            'status',
            'type',
            [
                'attribute' => 'member_type',
                'value' => function($model) {
                    if($model->member_type==0){
                        $member_vip = "所有会员";
                    }elseif($model->member_type==2){
                        $member_vip = "普通会员";
                    }elseif($model->member_type==3){
                        $member_vip = "高端会员";
                    }
                    elseif($model->member_type==4){
                        $member_vip = "至尊会员";
                    }
                    elseif($model->member_type==5){
                        $member_vip = "私人定制";
                    }else{
                        $member_vip = "网站会员";
                    }

                    return $member_vip;
                },
                'filter' => [
                    0 => '所有会员',
                    2 => '普通会员',
                    3 => '高端会员',
                    4 => '至尊会员',
                    5 => '私人定制',
                ]
            ],
            [
                'attribute' => 'is_activity',
                'value' => function($model) {
                    return $model->is_activity == 0 ? '正常充值' : '活动充值';
                },
                'filter' => [
                    0 => '正常充值',
                    1 => '活动充值'
                ]
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
