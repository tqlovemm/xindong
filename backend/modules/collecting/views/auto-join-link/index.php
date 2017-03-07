<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\collecting\models\AutoJoinLinkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Auto Join Links';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-join-link-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建自动入会链接', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'remarks',
            [
                'format' => 'raw',
                'label' => '生成链接',
                'value' => function ($data) {
                  return "http://13loveme.com/join/".$data->flag;

                }

            ],
            //'flag',
            'created_at:datetime',
            //'updated_at',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
