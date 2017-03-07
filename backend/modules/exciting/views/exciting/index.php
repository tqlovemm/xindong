<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "创建心动故事";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="album-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($this->title, ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= ListView::widget([
        'layout' => "{items}\n{pager}",
        'dataProvider' => $dataProvider,
        'itemView' => '_album',
        'options' => [
            'tag' => 'ul',
            'class' => 'album-all list-inline'
        ],
        'itemOptions' => [
            'class' => 'album-item list-unstyled',
            'tag' => 'li'
        ]
    ]); ?>

</div>
