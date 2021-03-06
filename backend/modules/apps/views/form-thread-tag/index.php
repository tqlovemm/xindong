<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\apps\models\FormThreadTagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '发帖标签列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-thread-tag-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新建标签', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'tag_name',
            'tag_py',
            'created_at:datetime',
            'sort',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->status == 0 ? '仅管理员可用' : '会员可用';
                },
                'filter' => [
                    0 => '仅管理员可用',
                    10 => '会员可用'
                ]
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
