<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\member\models\DatingVip */

$this->title = 'Update Dating Vip: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Dating Vips', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dating-vip-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
