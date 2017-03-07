<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\UserHowPlaySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-how-play-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'instruction') ?>

    <?= $form->field($model, 'rule') ?>

    <?= $form->field($model, 'inline_time') ?>

    <?= $form->field($model, 'flag') ?>

    <?php echo $form->field($model, 'weibo') ?>

    <?php echo $form->field($model, 'explain') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
