<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\forum\models\AnecdoteThreadComments */

$this->title = 'Create Anecdote Thread Comments';
$this->params['breadcrumbs'][] = ['label' => 'Anecdote Thread Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anecdote-thread-comments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
