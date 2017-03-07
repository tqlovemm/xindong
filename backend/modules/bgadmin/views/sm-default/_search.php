<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\bgadmin\models\SmadminMemberSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bgadmin-member-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'member_id') ?>

    <?= $form->field($model, 'number') ?>

    <?= $form->field($model, 'weicaht') ?>

    <?= $form->field($model, 'weibo') ?>

    <?= $form->field($model, 'cellphone') ?>

    <?php // echo $form->field($model, 'address_a') ?>

    <?php // echo $form->field($model, 'address_b') ?>

    <?php // echo $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'vip') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'time') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
