<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\weekly\models\WeeklyContent */

$this->title = 'Update Weekly Content: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Weekly Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="weekly-content-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
