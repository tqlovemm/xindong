<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\article\models\ArticleLabel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-label-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'labelname')->label("标签名")->textInput(['maxlength' => true]) ?>

    <div class="form-group field-articlelabel-thumb required">
        <label class="control-label" for="articlelabel-thumb">图片</label>
        <input type="hidden" name="ArticleLabelr[thumb]" value="">
        <input type="file" id="articlelabel-thumb" name="thumb">
        <div class="help-block"></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
