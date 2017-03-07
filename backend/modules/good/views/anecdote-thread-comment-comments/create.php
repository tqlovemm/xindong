<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\forum\models\AnecdoteThreadCommentComments */

$this->title = 'Create Anecdote Thread Comment Comments';
$this->params['breadcrumbs'][] = ['label' => 'Anecdote Thread Comment Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anecdote-thread-comment-comments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
