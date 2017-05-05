<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\male\models\MaleInfoTextSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Male Info Texts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="male-info-text-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Male Info Text', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'wechat',
            'cellphone',
            'email:email',
            'age',
            // 'car_type',
            // 'annual_salary',
            // 'height',
            // 'weight',
            // 'marry',
            // 'job',
            // 'offten_go',
            // 'hobby',
            // 'like_type',
            // 'remarks',
            // 'coin',
            // 'province',
            // 'city',
            // 'vip',
            // 'created_at',
            // 'updated_at',
            // 'flag',
            // 'status',
            // 'created_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
