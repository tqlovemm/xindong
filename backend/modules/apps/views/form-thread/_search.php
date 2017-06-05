<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\apps\models\FormThreadSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-thread-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'wid') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'content') ?>

    <?= $form->field($model, 'tag') ?>

    <?= $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'lat_long') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'is_top') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'read_count') ?>

    <?php // echo $form->field($model, 'thumbs_count') ?>

    <?php // echo $form->field($model, 'comments_count') ?>

    <?php // echo $form->field($model, 'admin_count') ?>

    <?php // echo $form->field($model, 'total_score') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
