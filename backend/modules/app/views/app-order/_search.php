<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\app\models\AppOrderListSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-order-list-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'order_number') ?>

    <?= $form->field($model, 'alipay_order') ?>

    <?= $form->field($model, 'total_fee') ?>

    <?php // echo $form->field($model, 'giveaway') ?>

    <?php // echo $form->field($model, 'subject') ?>

    <?php // echo $form->field($model, 'extra') ?>

    <?php // echo $form->field($model, 'channel') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'month_time') ?>

    <?php // echo $form->field($model, 'week_time') ?>

    <?php // echo $form->field($model, 'day_time') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php date('Y-m-d H:i',$form->field($model, 'updated_at')) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
