<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\AppWords */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'App Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-words-view">

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
            'content:ntext',
            'user_id',
            'address',
            //'img',
            'created_at',
            'updated_at',
            'flag',
            'status',
        ],
    ]) ?>
    <div><img src="<?=$model['img']?>" class="img-responsive" style="max-width: 200px;"></div>
</div>
