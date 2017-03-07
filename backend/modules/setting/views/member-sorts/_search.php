<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\MemberSortsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-sorts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'member_name') ?>

    <?= $form->field($model, 'member_introduce') ?>

    <?= $form->field($model, 'price_1') ?>
    <?= $form->field($model, 'price_2') ?>
    <?= $form->field($model, 'price_3') ?>

    <?= $form->field($model, 'discount') ?>

    <div class="form-group">
        <?= Html::submitButton('查找', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('复位', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
