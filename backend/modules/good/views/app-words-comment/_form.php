<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\AppWordsComment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-words-comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'words_id')->textInput() ?>

    <?= $form->field($model, 'first_id')->textInput() ?>

    <?= $form->field($model, 'second_id')->textInput() ?>

    <?= $form->field($model, 'img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'flag')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
