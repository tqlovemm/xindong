<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\dating\models\DatingContent */

$this->title = 'Update Dating Content: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Dating Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="Dating-content-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
