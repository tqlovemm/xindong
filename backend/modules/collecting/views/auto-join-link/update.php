<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\collecting\models\AutoJoinLink */

$this->title = 'Update Auto Join Link: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Auto Join Links', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="auto-join-link-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
