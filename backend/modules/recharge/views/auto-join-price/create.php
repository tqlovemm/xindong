<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\recharge\models\AutoJoinPrice */

$this->title = 'Create Auto Join Price';
$this->params['breadcrumbs'][] = ['label' => 'Auto Join Prices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-join-price-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
