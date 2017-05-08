<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\sm\models\SmCollectionFilesTextSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '西蒙之家会员信息表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sm-collection-files-text-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'member_id',
                'label' => '会员编号',
                'value' => function ($data) {
                    return $data->member_id;
                }
            ],
            'vip',
            'address',
            [
                'attribute' => '发送的链接',
                'label' => '发送的链接',
                'value' => function ($data) {
                    return "http://13loveme.com/sm?id=$data->flag";
                }
            ],
            [
                'attribute' => 'status',
                'format'=>'raw',
                'label' => '填写状态',
                'value' => function ($data) {
                    $result = $data->status==0?"未填写":"已经填写";
                    return $data->status.' — '.$result;
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
