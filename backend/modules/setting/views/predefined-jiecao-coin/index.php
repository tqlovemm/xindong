<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\setting\models\PredefinedJiecaoCoinSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '固定充值节操币';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="predefined-jiecao-coin-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建固定充值节操币', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'money',
            'giveaway',
            'status',
            'type',
            'member_type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
