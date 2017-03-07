<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\weixin\models\UserWeichat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-weichat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'openid')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?= $form->field($model, 'nickname')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?= $form->field($model, 'headimgurl')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
