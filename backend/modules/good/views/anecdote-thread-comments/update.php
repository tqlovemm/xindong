<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\forum\models\AnecdoteThreadComments */

$this->title = 'Update Anecdote Thread Comments: ' . ' ' . $model->cid;
$this->params['breadcrumbs'][] = ['label' => 'Anecdote Thread Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cid, 'url' => ['view', 'id' => $model->cid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="anecdote-thread-comments-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
