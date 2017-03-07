<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\bgadmin\models\BgadminMemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '十三平台';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bgadmin-member-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建会员', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('创建翻牌记录', ['/bgadmin/bgadmin-member-flop/create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('翻牌记录详情', ['/bgadmin/bgadmin-member-flop/index'], ['class' => 'btn btn-warning']) ?>
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
            'coin',
            //'time',
            //'updated_at:datetime',
            'created_at:datetime',
            'created_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
