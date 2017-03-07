<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\CreditValue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="credit-value-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput()->label("会员编号") ?>

    <?= $form->field($model, 'levels')->textInput() ?>

    <?= $form->field($model, 'viscosity')->textInput() ?>

    <?= $form->field($model, 'lan_skills')->textInput() ?>

    <?= $form->field($model, 'sex_skills')->textInput() ?>

    <?= $form->field($model, 'appearance')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
