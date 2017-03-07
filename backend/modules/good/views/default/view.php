<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\forum\models\AnecdoteThreads */

$this->title = $model->tid;
$this->params['breadcrumbs'][] = ['label' => 'Anecdote Threads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anecdote-threads-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if($model->status==2):?>
        <?= Html::a('审核', ['check-pass', 'id' => $model->tid],  [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => '确定通过吗？通过后将在网站前端看到',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif;?>
        <?= Html::a('Update', ['update', 'id' => $model->tid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('上传图片', ['upload', 'id' => $model->tid], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->tid], [
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
            'tid',
            'user_id',
            'content',
            'linkurl:url',
            'created_at',
            'updated_at',
            'thumbsup_count',
            'thumbsdown_count',
            'type',
            'status',
        ],
    ]) ?>

</div>
<div class="row">

    <?php foreach($model['img'] as $img):?>
     <span style="float: left;margin-left: 5px;"><img class="img-responsive" src="http://13loveme.com<?=$img['img']?>" width="120px;"></span>

    <?php endforeach;?>

</div>