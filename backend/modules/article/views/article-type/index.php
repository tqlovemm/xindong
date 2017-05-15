<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\article\models\ArticleTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '情话分类';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-type-index">

    <h1>情话分类列表</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加分类', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'typename',
//            [
//                'attribute' => 'created_at',
//                'value'=>
//                    function($model){
//                        return  date('Y-m-d H:i:s',$model->created_at);
//                    },
//            ],
            [
                'attribute' => 'status',
                'label'=>'状态 1:正常 2:已禁用',
                'value'=>
                    function($model){
                        $res = $model->status;
                        if($res == 1){
                            return Html::tag('font', "正常", ['color' => 'blue']);
                        }elseif($res == 2){
                            return "<font color='red'>已禁用</font>";
                        }
                    },
                'format' => 'raw',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
