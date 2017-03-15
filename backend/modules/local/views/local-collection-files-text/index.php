<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\local\models\LocalCollectionFilesTextSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '地方啪信息表';
$this->params['breadcrumbs'][] = $this->title;
$pre_url = Yii::$app->params['localandsm'];
?>
<div class="local-collection-files-text-index">

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
            [
                'attribute' => 'local',
                'label' => '地方啪',
                'value' => function ($data) {

                    $local =  \yii\helpers\ArrayHelper::map(\backend\modules\local\models\LocalCollectionCount::find()->all(),'number','number_name');
                    return $data->local.' — '.$local[$data->local];
                }
            ],
            [
                'attribute' => 'vip',
                'label' => '地方啪',
                'value' => function ($data) {

                    $local =  \yii\helpers\ArrayHelper::map(\backend\modules\local\models\LocalCollectionCount::find()->all(),'type','name');
                    return $data->vip.' — '.$local[$data->vip];
                }
            ],
             'address',

            [
                'attribute' => '发送的链接',
                'label' => '二维码',
                'value' => function ($data) {
                    return "http://13loveme.com/local?id=$data->flag";
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
