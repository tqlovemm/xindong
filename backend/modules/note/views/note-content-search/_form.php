<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\weekly\models\WeeklyContent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="weekly-content-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('编号') ?>
    <?= $form->field($model, 'thumb')->textInput(['maxlength' => true])->label('参赛宣言') ?>
    <?= $form->field($model, 'store_name')->textInput(['maxlength' => true])->label('存储名') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
