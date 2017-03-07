<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\forum\models\AnecdoteThreads */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="anecdote-threads-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput(['maxlength' => true])->label('平台id或者QQ OpenId') ?>

    <?= $form->field($model, 'content')->textInput(['maxlength' => true])->label('爆料内容') ?>

    <!--<?/*= $form->field($model, 'linkurl')->textInput(['maxlength' => true]) */?>

    <?/*= $form->field($model, 'created_at')->textInput() */?>

    <?/*= $form->field($model, 'updated_at')->textInput() */?>-->

    <?= $form->field($model, 'thumbsup_count')->textInput()->label('喜欢数') ?>

    <?= $form->field($model, 'thumbsdown_count')->textInput()->label('讨厌数') ?>
<!--
    <?/*= $form->field($model, 'type')->radioList([1=>'帖子',3=>'gif',4=>'jpg'])->label('帖子类型（一般默认帖子即可）') */?>-->

    <?= $form->field($model, 'status')->dropDownList([1=>'审核中',2=>'审核通过',3=>'审核不通过'])->label('审核状况(默认审核中)') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
