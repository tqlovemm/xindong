<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\member\models\UserBgRecord */

$this->title = 'Update User Bg Record: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Bg Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-bg-record-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
