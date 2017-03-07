<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\collecting\models\AutoJoinLink */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auto-join-link-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true])->label('给发谁或者其他标识') ?>

    <?= $form->field($model, 'status')->dropDownList(['0'=>'可用','1'=>'禁用'])->label('是否禁用') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
