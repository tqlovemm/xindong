<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WeeklyComment */

$this->title = 'Update Weekly Comment: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Weekly Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="weekly-comment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
