<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\financial\models\FinancialWechatPlatformSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Financial Wechat Platforms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="financial-wechat-platform-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Financial Wechat Platform', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'platform_name',
            'remarks',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
