<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\PredefinedJiecaoCoinSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="predefined-jiecao-coin-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'money') ?>

    <?= $form->field($model, 'giveaway') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'is_activity') ?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('复位', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
