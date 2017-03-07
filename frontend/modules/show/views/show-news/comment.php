<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerCss('

    .weekly-comment-form textarea{background-color:white;border:1px solid #E4E4E4;height:150px;}

');
?>

<div class="weekly-comment-form" style="background-color: transparent;">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'content')->textarea(['maxlength' => true])->label(false) ?>


    <div class="form-group center-block">
        <?= Html::submitButton($model->isNewRecord ? '发布' : '更新', ['class' => $model->isNewRecord ? 'btn btn-lg pull-right' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
