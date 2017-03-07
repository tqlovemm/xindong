<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ThirthFiles */

$this->title = 'Update Thirth Files: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Thirth Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="thirth-files-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'area'=>$areas
    ]) ?>

</div>
