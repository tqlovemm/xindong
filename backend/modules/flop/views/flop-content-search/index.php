<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\flop\models\FlopContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '翻牌搜索';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCss("

        #w0:after{content:'.';display:block;height:0;clear:both;visibility: hidden;}
       .table-striped img{width:100px;}
       .form-group{width:25%;float:left;}
       .form-group label{width:20%;}
       .form-group input{width:80%;}
       .form-group select{width:80%;}
       .form-group label,.form-group input{float:left;}
");
?>
<div class="weekly-content-index">

    <h1 style=""><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <p class="hidden">
        <?= Html::a('Create Flop Content', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
      /*  'filterModel' => $searchModel,*/
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'area',
            'number',
            'path:image',
            'like_count',
            'nope_count',
            'is_cover',
            'other',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
