<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\article\models\ArticleAdverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '情话广告';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-adver-index">

    <h1>情话广告列表</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('情话广告添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'thumb',
            'created_id',
            'url:url',
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
