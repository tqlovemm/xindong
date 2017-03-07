<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\recharge\models\RechargeContent */

$this->title = 'Create Recharge Content';
$this->params['breadcrumbs'][] = ['label' => 'Recharge Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recharge-content-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
