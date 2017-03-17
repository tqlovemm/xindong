<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<div class="setting-form" style="padding: 0 10px;">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'sex')->dropDownList([0=>'男生',1=>'女生'])->label('性别') ?>
    <?= $form->field($model, 'local')->dropDownList($local, [
        'prompt'=>'---请选择地方啪---',
        'onchange'=>'$.post("/local/default/lists?id='.'"+$(this).val(),function(data){
                $("select#localcollectionfilestext-vip").html(data);
            });',
    ])->label('地方啪') ?>
    <?= $form->field($model, 'vip')->dropDownList($vip,['prompt'=>'---请选择会员等级---'])->label('会员等级') ?>
    <?= $form->field($model, 'address')->dropDownList($areas, ['prompt'=>'---请选择地区---'])->label('地区') ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
