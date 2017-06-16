<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>

<div class="bgadmin-member-form">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'show')->dropDownList([10=>'正常不删档',5=>'删档但接受推送',0=>'完全退出']) ?>

    <?= $form->field($model, 'sex')->dropDownList([0=>'男生'],['prompt'=>'----请选择性别----']) ?>

    <?= $form->field($model, 'number')->textInput()->label('会员编号') ?>

    <?= $form->field($model, 'vip')->dropDownList([0=>'非会员',2=>'普通会员',3=>'高端会员',4=>'至尊会员',5=>'私人定制'],['prompt'=>'----会员等级----']) ?>

    <?= $form->field($model, 'weicaht')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weibo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cellphone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_a')->dropDownList($area,['prompt'=>'----请选择地区----']) ?>

    <?= $form->field($model, 'address_b')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coin')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['id'=>'create_success','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>