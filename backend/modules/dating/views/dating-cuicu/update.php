<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\member\models\DatingCuicu */

$this->title = 'Update Dating Cuicu: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Dating Cuicus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dating-cuicu-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
