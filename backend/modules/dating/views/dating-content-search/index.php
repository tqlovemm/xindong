<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\dating\models\DatingContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dating Contents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dating-content-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create dating Content', ['create'], ['class' => 'btn btn-success']) ?>
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
