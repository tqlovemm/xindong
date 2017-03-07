<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\flop\models\FlopContent */

$this->title = $model->area;
$this->params['breadcrumbs'][] = ['label' => 'Flop Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weekly-content-view">

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
            'flop_id',
            'area',
            'number',
            'content',
            'like_count',
            'nope_count',
            'path:image',
            'store_name',
            'created_at:time',
            'created_by',
            'is_cover',
        ],
    ]) ?>

</div>
