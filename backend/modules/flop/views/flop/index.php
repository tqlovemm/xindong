<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "创建翻牌";
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->session->getFlash('success');
?>
<div class="flop-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($this->title, ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('翻牌详情', ['/flop/flop/flop-data'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('档案被翻拍详情', ['/flop/flop/flop-content-list'], ['class' => 'btn btn-danger']) ?>
        <?= Html::a('搜索', ['/flop/flop-content-search'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('更新数据', ['/flop/flop-content/update'], ['class' => 'btn btn-primary']) ?>

    </p>

    <?= ListView::widget([
        'layout' => "{items}\n{pager}",
        'dataProvider' => $dataProviders,
        'itemView' => '_flop',
        'options' => [
            'tag' => 'ul',
            'class' => 'flop-all list-inline'
        ],
        'itemOptions' => [
            'class' => 'flop-item list-unstyled',
            'tag' => 'li'
        ]
    ]); ?>

</div>
