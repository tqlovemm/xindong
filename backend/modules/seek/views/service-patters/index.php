<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\seek\models\ServicePattersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Service Patters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-patters-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建话术', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'pid',
            [
                'attribute' => 'subject',
                'label' => '会员问题',
                'value' => function ($data) {
                    return mb_substr($data->subject,0,30,'utf8');
                }
            ],
            [
                'attribute' => 'message',
                'label' => '经典回答',
                'value' => function ($data) {
                    return mb_substr($data->message,0,30,'utf8');
                }
            ],
            [
                'attribute' => 'chrono',
                'label' => '创建时间',
                'value' => function ($data) {
                    return date('Y-m-d H:i:s',$data->chrono);
                }
            ],
            'created_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
