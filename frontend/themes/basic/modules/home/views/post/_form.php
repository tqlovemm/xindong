<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCss('

     .edui-body-container img{width:100px;height:100px;float:left;}
    .edui-body-container p:nth-last-child(1){clear:both;}
');
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title', [
      'template' => "<div class=\"input-group\"><span class=\"input-group-addon\">标题</span>{input}</div>",
    ])->textInput(['maxlength' => 128, 'autocomplete'=>'off']) ?>

    <?= $form->field($model, 'content')->widget('shiyang\umeditor\UMeditor', [
        'clientOptions' => [
            'initialFrameHeight' => 230,
            'toolbar' => [
                'undo', 'redo','cleardoc','emotion','image','scrawl','preview',

            ],
        ]
    ])->label(false) ?>
    
    <?= $form->field($model, 'tags')->textarea(['rows' => 1])->label('标签，不同标签之间逗号隔开') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
