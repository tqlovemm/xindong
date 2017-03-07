<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\AppWordsComment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'App Words Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-words-comment-view">

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
            'words_id',
            'first_id',
            'second_id',
            'img',
            'comment:ntext',
            'flag',
            'created_at',
            'updated_at',
        ],
    ]) ?>
    <div><img class="img-responsive" src="<?=$model['img']?>" style="max-width: 200px"></div>
</div>
