<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\CheckService */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="check-service-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'number')->textInput()->label('客服编号') ?>
    <?= $form->field($model, 'nickname')->textInput()->label('微信昵称') ?>

<!--<?///*= $form->field($model, 'flag')->textInput() */?> -->
    <!--<?/*= $form->field($model, 'created_at')->textInput() */?>

    <?/*= $form->field($model, 'updated_at')->textInput() */?>-->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
