<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\forum\models\AnecdoteThreadThumbs */

$this->title = 'Create Anecdote Thread Thumbs';
$this->params['breadcrumbs'][] = ['label' => 'Anecdote Thread Thumbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anecdote-thread-thumbs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
