<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\bgadmin\models\BgadminMemberFlopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '翻牌记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bgadmin-member-flop-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建翻牌记录', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'floping_number',
            'floped_number',
            'created_at:datetime',
            'created_by',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
