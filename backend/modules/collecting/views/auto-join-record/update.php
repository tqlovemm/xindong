<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\collecting\models\AutoJoinRecord */

$this->title = 'Update Auto Join Record: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Auto Join Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="auto-join-record-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
