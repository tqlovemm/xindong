<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\WeichatDazzleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="weichat-dazzle-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sex') ?>

    <?= $form->field($model, 'enounce') ?>

    <?= $form->field($model, 'openId') ?>

    <?= $form->field($model, 'plateId') ?>

    <?php echo $form->field($model, 'num') ?>

    <?php echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
