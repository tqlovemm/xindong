<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\home\models\Album */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="album-form">

    <?php $form = ActiveForm::begin([
        'method'=>'post',
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model,'status')->dropDownList([2=>'反馈',0=>'声色',3=>'活动'])->label('类型')?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => 128]) ?>
    <?= $form->field($model, 'content')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'url')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model,'file')->fileInput()?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
