<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\authentication\models\AdminPush */

$this->title = 'Update Admin Push: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Admin Pushes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="admin-push-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
