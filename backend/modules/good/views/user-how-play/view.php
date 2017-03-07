<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\UserHowPlay */

$this->title = "详情";
$this->params['breadcrumbs'][] = ['label' => 'User How Plays', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-how-play-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'instruction:ntext',
            'rule:ntext',
            'inline_time:ntext',
            'weibo:ntext',
            'explain',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
