<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\seventeen\models\SeventeenFilesTextSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seventeen-files-text-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'weichat') ?>

    <?= $form->field($model, 'cellphone') ?>

    <?= $form->field($model, 'address_province') ?>

    <?= $form->field($model, 'address_city') ?>

    <?php // echo $form->field($model, 'address_detail') ?>

    <?php // echo $form->field($model, 'education') ?>

    <?php // echo $form->field($model, 'age') ?>

    <?php // echo $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'height') ?>

    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'cup') ?>

    <?php // echo $form->field($model, 'job') ?>

    <?php // echo $form->field($model, 'job_detail') ?>

    <?php // echo $form->field($model, 'gotofield') ?>

    <?php // echo $form->field($model, 'weibo') ?>

    <?php // echo $form->field($model, 'id_number') ?>

    <?php // echo $form->field($model, 'pay') ?>

    <?php // echo $form->field($model, 'qq') ?>

    <?php // echo $form->field($model, 'extra') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'flag') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
