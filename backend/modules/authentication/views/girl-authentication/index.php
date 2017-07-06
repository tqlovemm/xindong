<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\authentication\models\GirlAuthenticationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '女生认证';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="girl-authentication-index">

    <h1>女生认证列表</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'user_id',
            [
                'attribute' => 'video_url',
                'value'=> function($model){
                        $res = $model->video_url;
                        return Html::tag('a', $res, ['target' => '_blank','href'=>$res]);
                    },
                'format' => 'raw',
            ],
            [
                'attribute' => 'created_at',
                'value'=>
                    function($model){
                        return  date('Y-m-d H:i:s',$model->created_at);
                    },
            ],
            [
                'attribute' => 'status',
                'label'=>'状态 1:认证成功 2:认证失败 3:未认证',
                'value'=>
                    function($model){
                        $res = $model->status;
                        if($res == 1){
                            return Html::tag('font', "认证成功", ['color' => 'blue']);
                        }elseif($res == 2){
                            return "<font color='red'>认证失败</font>";
                        }elseif($res == 3){
                            return "<font color='green'>审核中</font>";
                        }
                    },
                'format' => 'raw',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
