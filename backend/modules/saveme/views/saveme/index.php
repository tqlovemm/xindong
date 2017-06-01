<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\saveme\models\SavemeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '救我管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="saveme-index">

    <h1>救我发布列表</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Saveme', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'created_id',
            'address',
            'content',
            'price',
            [
                'attribute' => 'end_time',
                'value'=>
                    function($model){
                        return  date('Y-m-d H:i:s',$model->end_time);
                    },
            ],
            [
                'attribute' => 'status',
                'label'=>'状态 1:正常 2:已结束 0:已删除',
                'value'=>
                    function($model){
                        $res = $model->status;
                        $endtime = $model->end_time;
                        if($res == 1){
                            if($endtime < time()){
                                return "<font color='orange'>已过期</font>";
                            }else{
                                return Html::tag('font', "正常", ['color' => 'blue']);
                            }
                        }elseif($res == 2){
                            return "<font color='green'>已结束</font>";
                        }elseif($res == 0){
                            return "<font color='red'>已删除</font>";
                        }elseif($res == 3){
                            return "<font color='red'>未审核</font>";
                        }
                    },
                'format' => 'raw',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
