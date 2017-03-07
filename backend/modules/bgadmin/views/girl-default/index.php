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
            'weibo',
            'cellphone',
            'address_a',
            'address_b',
            'sex',
            'vip',
            'coin',
            //'time',
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
                'label' => '是否保密',
                'format'=>'html',
                'value' => function ($data) {
                    if($data->foreign==0){
                        return "照片公开";
                    }else{
                        return "<span style='color:red;'>照片打码</span>";
                    }
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
