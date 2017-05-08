<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\saveme\models\SavemeInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="saveme-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'saveme_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apply_uid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
