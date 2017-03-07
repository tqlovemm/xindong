<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\forum\models\AnecdoteUsers */

$this->title = 'Create Anecdote Users';
$this->params['breadcrumbs'][] = ['label' => 'Anecdote Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anecdote-users-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
