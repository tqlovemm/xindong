<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\AppWordsComment */

$this->title = 'Update App Words Comment: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'App Words Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="app-words-comment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
