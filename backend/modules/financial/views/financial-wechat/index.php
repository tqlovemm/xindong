<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\financial\models\FinancialWechatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '客服微信号入会升级记录统计';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCss("
.modal-content{border-radius:5px;}

");
?>
<div class="financial-wechat-index">
    <p>
        <?= Html::a('创建微信号统计', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('今日记录', ['today-record'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'wechat',
            //'remarks',
            'member_count',
            'loose_change',
            [
                'attribute' => 'created_by',
                'format' => 'text',
                'label' => '创建管理员',
                'value'=>function($model){
                    return \backend\models\User::findOne($model->created_by)->username .'：'.\backend\models\User::findOne($model->created_by)->nickname;
                }
            ],
            [
                'attribute' => 'created_at',
                'format' => 'text',
                'label' => '创建时间',
                'value'=>function($model){
                    return date('Y-m-d H:i:s',$model->created_at);
                }
            ],
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->status == 0 ? '不可见' : '可见';
                },
                'filter' => [
                    0 => '不可见',
                    10 => '可见'
                ]
            ],
            [
                'attribute' => '新增操作',
                'format' => 'raw',
                'label' => '新增操作',
                'value'=>function($model){
                    return "<a href='".Url::to(['/financial/financial-wechat-member-increase/create','wechat_id'=>$model->id])."' class='btn-sm btn-success'>今日统计</a> <a href='".Url::to(['/financial/financial-wechat-join-record/create','wechat_id'=>$model->id])."' class='btn-sm btn-warning'>入会记录</a>";
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>