<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\forum\models\AnecdoteUsers */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Anecdote Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anecdote-users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('上传头像', ['upload', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
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
            'user_id',
            'headimgurl:url',
            'username',
        ],
    ]) ?>

</div>
