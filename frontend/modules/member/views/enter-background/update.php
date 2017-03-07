<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\member\models\EnterTheBackground */

$this->title = 'Update Enter The Background: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Enter The Backgrounds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="enter-the-background-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
