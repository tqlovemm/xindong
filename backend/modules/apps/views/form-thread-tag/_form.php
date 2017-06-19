<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model api\modules\v11\models\FormThreadTag */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-thread-tag-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tag_name')->textInput(['maxlength' => true])->label('中文名称（如：#游戏#）') ?>

    <?= $form->field($model, 'tag_py')->textInput(['maxlength' => true])->label('全拼音（如：youxi）') ?>

    <?= $form->field($model, 'sort')->textInput()->label('排序（数值越大越靠后）') ?>
    <?= $form->field($model, 'status')->dropDownList([10=>'会员可用',0=>'仅管理员可用'])->label('会员是否可见') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
