<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\collecting\models\AutoJoinRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auto-join-record-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'member_sort')->textInput() ?>

    <?= $form->field($model, 'member_area')->textInput() ?>

    <?= $form->field($model, 'recharge_type')->textInput() ?>

    <?= $form->field($model, 'cellphone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'extra')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
