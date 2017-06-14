<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\apps\models\FormThreadCommentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-thread-comments-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'comment_id') ?>

    <?= $form->field($model, 'thread_id') ?>

    <?= $form->field($model, 'first_id') ?>

    <?= $form->field($model, 'second_id') ?>

    <?= $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'flag') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
