<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\article\models\ArticleLabelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '情话标签';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-label-index">

    <h1>情话标签列表</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加标签', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'labelname',
            'thumb',
            [
                'attribute' => 'created_at',
                'value'=>
                    function($model){
                        return  date('Y-m-d H:i:s',$model->created_at);
                    },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
