<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="thirth-files-search row">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="col-md-2"><?= $form->field($model, 'number')?></div>
    <div class="col-md-2"><?= $form->field($model, 'user_id') ?></div>
    <div class="col-md-2"><?= $form->field($model, 'type')->dropDownList([10=>'年费会员',5=>'半年费会员',1=>'包月会员',2=>'季度会员'], ['prompt'=>'==请选择会员类型==']) ?></div>
    <div class="col-md-2"><?= $form->field($model, 'vip')->dropDownList([3=>'高端会员',4=>'至尊会员',0=>'包月会员',5=>'私人定制'], ['prompt'=>'==请选择等级=='])?></div>
    <div class="col-md-2"><?= $form->field($model, 'admin')?></div>

    <div class="form-group col-md-2">
        <label class="control-label center-block">操作</label>
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
