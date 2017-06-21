<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\bgadmin\models\BgadminMemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '十三平台';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bgadmin-member-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建会员', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('创建翻牌记录', ['/bgadmin/bgadmin-member-flop/create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('翻牌记录详情', ['/bgadmin/bgadmin-member-flop/index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('生成女生资料收集链接', ['send-girl-url'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('未填女生', ['/flop/dating-bg'], ['class' => 'btn btn-danger']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'member_id',
            'number',
            'weicaht',
            'cellphone',
            'address_a',
            'address_b',
            'coin',
            'age',
            //'updated_at:datetime',
            [
                'attribute' => '创建时间',
                'label' => '创建时间',
                'value' => function ($data) {
                    return date('Y-m-d H:i',$data->created_at);
                }
            ],
            //'created_at:datetime',
            'created_by',
            [
                'attribute' => 'foreign',
                'format'=>'html',
                'value' => function ($data) {
                    if($data->foreign==0){
                        return "<span style='color:red;font-weight: bold;'>照片公开</span>";
                    }else{
                        return "<span style='color:#0a6eff;font-weight: bold;'>照片打码</span>";
                    }
                },
                'filter' => [
                    0 => '照片公开',
                    1 => '照片打码',
                ]
            ],
            [
                'attribute' => 'show',
                'format'=>'html',
                'value' => function ($data) {
                    if($data->show==0){
                        return "<span style='color:red;font-weight: bold;'>完全退出</span>";
                    }elseif($data->show==10){
                        return "<span style='color:#06c232;font-weight: bold;'>正常</span>";
                    }else{
                        return "<span style='color:#0a6eff;font-weight: bold;'>删档但接受推送</span>";
                    }
                },
                'filter' => [
                    0 => '完全退出',
                    10 => '正常',
                    5 => '删档但接受推送',
                ]
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
