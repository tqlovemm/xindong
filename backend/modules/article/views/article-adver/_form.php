<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\article\models\ArticleAdver */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-adver-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="form-group field-articleadver-thumb required">
        <label class="control-label" for="articleadver-thumb">广告图</label>
        <input type="hidden" name="ArticleAdver[thumb]" value="">
        <input type="file" id="articleadver-thumb" name="thumb">
        <div class="help-block"></div>
    </div>


    <?= $form->field($model, 'url')->label("链接")->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
