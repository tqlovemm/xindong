<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\flop\models\FlopContentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="weekly-content-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'number') ?>
    <?= $form->field($model, 'other')->dropDownList([1=>'好评',0=>'非好评'],['prompt'=>'....'])->label('是否好评') ?>

    <?php // echo $form->field($model, 'store_name') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'is_cover') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
