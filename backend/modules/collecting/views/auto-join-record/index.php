<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\collecting\models\AutoJoinRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Auto Join Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-join-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Auto Join Record', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'member_sort',
            //'member_area',
            //'recharge_type',

            'cellphone',
            'created_at:datetime',
            // 'updated_at',
            'extra',
            [

             'attribute' => 'origin',
             'format' => 'text',
             'label' => '来自于',
            ],

            [
                'format' => 'raw',
                'label' => '入会等级',
                'value' => function ($data) {
                    if($data->member_sort==2){
                        return '普通会员';
                    }elseif($data->member_sort==3){
                        return '高端会员';
                    }elseif($data->member_sort==4){
                        return '至尊会员';
                    }else{
                        return '<span style="color:blue;">未知类型</span>';
                    }

                }

            ],
            [
                'format' => 'raw',
                'label' => '地区',
                'value' => function ($data) {
                    if($data->member_area==3){
                        return '北上广苏浙';
                    }elseif($data->member_area==1){
                        return '新蒙青甘藏宁琼';
                    }elseif($data->member_area==2){
                        return '包括海外在内的其他地区';
                    }else{
                        return '<span style="color:blue;">未知地区</span>';
                    }

                }

            ],
            [

                'attribute' => 'price',
                'format' => 'text',
                'label' => '价格',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
