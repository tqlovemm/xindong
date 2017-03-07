<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="flop-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'area')->textInput(['maxlength' => 128])->label('区域')?>
    <?= $form->field($model, 'status')->dropDownList([1=>'是'])->label('是否发布')?>
    <?= $form->field($model, 'sex')->dropDownList([0=>'男生档案',1=>'女生档案'],['prompt'=>'性别'])?>
    <?= $form->field($model, 'content')->textInput(['maxlength' => 128])->label('主题内容') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
