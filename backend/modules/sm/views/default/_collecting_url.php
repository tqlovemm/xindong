<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<div class="setting-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'sex')->dropDownList([0=>'男生',1=>'女生'])->label('性别') ?>
    <?= $form->field($model, 'vip')->dropDownList(\yii\helpers\ArrayHelper::map(\backend\modules\sm\models\SmCollectionCount::find()->all(),'type','name'))->label('会员等级') ?>
    <?= $form->field($model, 'address')->dropDownList($areas, ['prompt'=>'---请选择地区---'])->label('地区') ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
