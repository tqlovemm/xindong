<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\dating\models\Dating */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Datings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dating-view">

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
            'title2',
            'title3',
            'content',
            'introduction',
            'cover_id',
            'created_at',
            'updated_at',
            'created_by',
            'enable_comment',
            'status',
            'url:url',
            'number',
            'avatar',
            'worth',
            'expire',
            'full_time:datetime',
            'platform',
            'flag',
        ],
    ]) ?>

</div>
