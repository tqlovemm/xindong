<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\bgadmin\models\UserBgRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Bg Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-bg-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User Bg Record', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'user_id',
            'description',
            [
                'attribute' => '时间',
                'label' => '时间',
                'value' => function ($data) {
                    return date('Y-m-d H:i:s',$data->created_at);
                }
            ],

        ],
    ]); ?>

</div>
