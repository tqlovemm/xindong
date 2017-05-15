<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="article-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label("标题") ?>

    <div class="form-group field-article-wimg required">
        <label class="control-label" for="article-wimg">描述图片</label>
        <input type="file" id="article-wimg" name="wimg">

        <div class="help-block"></div>
    </div>

    <?= $form->field($model, 'wtype')->textInput()->dropDownList($type) ?>
    <?= $form->field($model,'content')->label("内容")->widget('common\widgets\ueditor\ueditor',[
        'options'=>[
            'initialFrameHeight' => 300,
            'lang' =>'zh-cn',
        ]
    ]) ?>



    <?= $form->field($model, 'wclick')->textInput()->label("点击数") ?>

    <?= $form->field($model, 'wdianzan')->textInput()->label("点赞数") ?>

    <?= $form->field($model, 'hot')->textInput()->dropDownList([1=>'HOT',2=>'非HOT']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
