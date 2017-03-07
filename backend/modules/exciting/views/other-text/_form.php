<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="album-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'title')?>
    <?= $form->field($model, 'content')?>
    <?= $form->field($model, 'type')->dropDownList([1=>'优质男生',5=>'优质女生',2=>'心动后援',3=>'救火',4=>'福利'])?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
