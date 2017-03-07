<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\forum\models\AnecdoteThreadThumbs */

$this->title = 'Update Anecdote Thread Thumbs: ' . ' ' . $model->thumbs_id;
$this->params['breadcrumbs'][] = ['label' => 'Anecdote Thread Thumbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->thumbs_id, 'url' => ['view', 'id' => $model->thumbs_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="anecdote-thread-thumbs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
