<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="thirth-files-search row">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="col-md-1"><?= $form->field($model, 'sid')?></div>
    <div class="col-md-1"><?= $form->field($model, 'user_id') ?></div>
    <div class="col-md-2"><?= $form->field($model, 'status')->dropDownList([10=>'等待中',11=>'成功',12=>'失败'],['prompt'=>'---请选择审核状态---'])?></div>
    <div class="col-md-2"><?= $form->field($model, 'zid')?></div>

    <div class="form-group col-md-2">
        <label class="control-label center-block">操作</label>
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('复位', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
