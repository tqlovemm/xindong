<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model api\modules\v11\models\FormThreadComments */

$this->title = $model->comment_id;
$this->params['breadcrumbs'][] = ['label' => 'Form Thread Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-thread-comments-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'comment_id' => $model->comment_id, 'thread_id' => $model->thread_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'comment_id' => $model->comment_id, 'thread_id' => $model->thread_id], [
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
            'comment_id',
            'thread_id',
            'first_id',
            'second_id',
            'comment:ntext',
            'flag',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
