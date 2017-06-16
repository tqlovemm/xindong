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
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'member_id',
            'number',
            'weicaht',
            'weibo',
            'cellphone',
            'address_a',
            'address_b',
            'sex',
            'vip',
            'coin',
            //'time',
            //'updated_at:datetime',
            'created_at:datetime',
            'created_by',
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
