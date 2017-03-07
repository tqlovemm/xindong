<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\forum\models\AnecdoteThreadReport */

$this->title = 'Create Anecdote Thread Report';
$this->params['breadcrumbs'][] = ['label' => 'Anecdote Thread Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anecdote-thread-report-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
