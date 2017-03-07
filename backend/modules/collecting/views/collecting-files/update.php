<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Collecting17FilesText */

$this->title = 'Update Collecting17 Files Text: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Collecting17 Files Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="collecting17-files-text-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
