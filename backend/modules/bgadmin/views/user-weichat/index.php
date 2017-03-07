<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\bgadmin\models\UserWeichatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Weichats';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-weichat-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User Weichat', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'openid',
            'number',
            'nickname',
            //'headimgurl:url',
            'address',
            [
                'attribute' => 'create_at',
                'label' => 'create_at',
                'value' => function ($data) {
                   return date('Y-m-d H:i:s',$data->created_at);
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
