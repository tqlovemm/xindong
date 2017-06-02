<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\article\models\ArticleLabel */

$this->title = $model->lid;
$this->params['breadcrumbs'][] = ['label' => 'Article Labels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-label-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->lid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->lid], [
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
            'lid',
            'labelname',
            'thumb',
            'created_at',
            'updated_at',
            'status',
        ],
    ]) ?>

</div>
