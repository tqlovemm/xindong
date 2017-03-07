<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\app\models\AppOrderList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-order-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'order_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alipay_order')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'giveaway')->textInput() ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?><!--

    <?/*= $form->field($model, 'extra')->textarea(['rows' => 6]) */?>-->

    <?= $form->field($model, 'channel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

   <!-- <?/*= $form->field($model, 'month_time')->textInput() */?>

    <?/*= $form->field($model, 'week_time')->textInput() */?>

    <?/*/*= $form->field($model, 'created_at')->textInput() */?>

    <?/*/*= date('Y-m-d H:i',$form->field($model, 'updated_at')->textInput()) */?>-->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
