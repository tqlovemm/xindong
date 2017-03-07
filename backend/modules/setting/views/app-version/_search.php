<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\setting\models\AppVersionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-version-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'build') ?>

    <?= $form->field($model, 'version') ?>

    <?= $form->field($model, 'app_name') ?>

    <?= $form->field($model, 'platform') ?>

    <?php // echo $form->field($model, 'update_info') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'is_force_update') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
