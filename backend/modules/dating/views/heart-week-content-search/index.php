<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\recharge\models\RechargeContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '心动周刊';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recharge-content-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建心动周刊', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'album_id',
            'name',
            'thumb',
            'path',
            // 'store_name',
            // 'created_at',
            // 'created_by',
            // 'is_cover',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
