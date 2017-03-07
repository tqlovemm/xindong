<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\app\models\TurnOverCardSuccess */

$this->title = 'Update Turn Over Card Success: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Turn Over Card Successes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="turn-over-card-success-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
