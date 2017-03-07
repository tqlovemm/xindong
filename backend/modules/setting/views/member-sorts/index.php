<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\setting\models\MemberSortsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '会员种类';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-sorts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建会员种类', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'member_name',
            'member_introduce',
            'permissions',
            'price_1',
            'price_2',
            'price_3',
            'discount',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
