<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\saveme\models\SavemeInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '救我管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="saveme-info-index">

    <h1>救我申请列表</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Saveme Info', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'saveme_id',
            'apply_uid',
            ['label'=>'用户名','attribute' => 'username','value' => 'user.username' ],
            [
                'attribute' => 'created_at',
                'value'=>
                    function($model){
                        return  date('Y-m-d H:i:s',$model->created_at);
                    },
            ],
            [
                'attribute' => 'status',
                'label'=>'状态 1:已接受 2:已拒绝 0:未审核',
                'value'=>
                    function($model){
                        $res = $model->status;
                        if($res == 1){
                            return "<font color='blue'>已接受</font>";
                        }elseif($res == 2){
                            return "<font color='red'>已拒绝</font>";
                        }elseif($res == 0){
                            return "<font color='green'>未审核</font>";
                        }
                    },
                'format' => 'raw',
            ],

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
