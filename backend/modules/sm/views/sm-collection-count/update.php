<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\sm\models\SmCollectionCount */

$this->title = 'Update Sm Collection Count: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sm Collection Counts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sm-collection-count-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
