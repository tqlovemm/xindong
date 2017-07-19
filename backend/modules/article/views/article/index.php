<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\article\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '情话管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1>情话列表</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加情话', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'created_id',
            ['label'=>'用户名','attribute' => 'username','value' => 'user.username' ],
            'title',
            'miaoshu',
            'wtype',
            'wimg',
//            'content:ntext',
            // 'wclick',
            // 'wdianzan',
            // 'hot',
            // 'created_at',
            // 'updated_at',
            // 'status',


        ],
    ]); ?>

</div>
