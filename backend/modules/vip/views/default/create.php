<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="create">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-success" style="padding: 20px;">
            <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'number') ?>
                <?= $form->field($model, 'vip')->dropDownList([3=>'高端会员',4=>'至尊会员',0=>'包月会员',5=>'私人定制'], ['prompt'=>'==请选择等级==']) ?>
                <?= $form->field($model, 'type')->dropDownList([10=>'年费会员',5=>'半年费会员',1=>'包月会员',2=>'季度会员'], ['prompt'=>'==请选择会员类型==']) ?>
                <?= $form->field($model, 'expire')->textInput(['type'=>'date']) ?>
                <?= $form->field($model, 'extra') ?>
                <div class="form-group">
                    <?= Html::submitButton('确定', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
