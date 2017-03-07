<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\app\models\AppUserProfile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-user-profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput(['disabled'=>true]) ?>

    <?= $form->field($model, 'worth')->textInput() ?>

    <?= $form->field($model, 'birthdate')->textInput(['disabled'=>true]) ?>

    <?= $form->field($model, 'signature')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?= $form->field($model, 'is_marry')->textInput(['disabled'=>true]) ?>

    <?= $form->field($model, 'height')->textInput(['disabled'=>true]) ?>

    <?= $form->field($model, 'weight')->textInput(['disabled'=>true]) ?>

    <?= $form->field($model, 'flag')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
