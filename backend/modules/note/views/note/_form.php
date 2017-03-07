<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="album-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'title')->textInput(['maxlength' => 128])->label('标题') ?>
    <?= $form->field($model, 'content')->textInput(['maxlength' => 512])->label('主题内容') ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
