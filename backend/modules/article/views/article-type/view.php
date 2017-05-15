<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\article\models\ArticleType */

$this->title = $model->tid;
$this->params['breadcrumbs'][] = ['label' => 'Article Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-type-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->tid], ['class' => 'btn btn-primary']) ?>
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
            'typename',
            'created_at',
            'updated_at',
            'status',
        ],
    ]) ?>

</div>
