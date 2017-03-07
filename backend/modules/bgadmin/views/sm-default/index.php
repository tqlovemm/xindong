<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\bgadmin\models\SmadminMemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '西檬之家';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bgadmin-member-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建会员', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'member_id',
            'number',
            'weicaht',
            'weibo',
            'cellphone',
            'address_a',
            'address_b',
            'sex',
            'vip',
            //'status',
            'time',
            'updated_at:datetime',
            'created_at:datetime',
            'created_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
