<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\active\models\NewYear */

$this->title = 'Update New Year: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'New Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="new-year-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
