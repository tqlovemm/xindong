<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\forum\models\AnecdoteThreadCommentComments */

$this->title = 'Update Anecdote Thread Comment Comments: ' . ' ' . $model->ccid;
$this->params['breadcrumbs'][] = ['label' => 'Anecdote Thread Comment Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ccid, 'url' => ['view', 'id' => $model->ccid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="anecdote-thread-comment-comments-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
