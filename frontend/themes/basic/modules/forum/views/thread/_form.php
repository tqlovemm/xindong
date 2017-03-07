<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->registerCss('

     .edui-body-container img{width:100px;height:100px;float:left;}
    .edui-body-container p:nth-last-child(1){clear:both;}
');
?>

<div class="thread-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'content')->widget('shiyang\umeditor\UMeditor', [
            'clientOptions' => [
                'initialFrameHeight' => 200,
                'toolbar' => [
                    '| emotion image |',
                ],
            ]
        ])->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '发帖' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'autocomplete'=>'off']) ?>
        </div>

        <?php ActiveForm::end(); ?>
</div>