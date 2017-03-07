<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\forum\models\AnecdoteThreadReport */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Anecdote Thread Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anecdote-thread-report-view">

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
            'tid',
            'by_who',
            'reason',
            'result',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
<div>
    <?php foreach($model['img'] as $img):?>
    <span style="margin-left: 5px;float: left"><img class="img-responsive" src="http://13loveme.com<?=$img['img']?>" width="120px;"></span>
    <?php endforeach;?>
</div>
