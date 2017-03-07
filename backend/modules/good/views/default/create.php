<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\forum\models\AnecdoteThreads */

$this->title = 'Create Anecdote Threads';
$this->params['breadcrumbs'][] = ['label' => 'Anecdote Threads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anecdote-threads-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
