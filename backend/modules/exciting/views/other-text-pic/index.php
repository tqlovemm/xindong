<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\weekly\models\WeeklyContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '心动故事内容';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weekly-content-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Weekly Content', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'pid',
           // 'tid',
            'name',
            'content',
            'pic_path',
            'created_at',
            'type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
