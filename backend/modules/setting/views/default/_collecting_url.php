<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
        if(Yii::$app->user->id==13921){
            echo $form->field($model, 'id')->textInput(['disabled'=>true])->label('admin_syn不可填写');
        }else{
            echo $form->field($model, 'id')->textInput()->label('会员编号，可不填，不填则由系统自动生成（建议新入会会员由系统自动生成，老会员自己填写）');
        }
    ?>
    <?= $form->field($model, 'sex')->dropDownList([0=>'男生',1=>'女生'])->label('性别') ?>
    <?= $form->field($model, 'vip')->dropDownList([2=>'普通会员',3=>'高端会员',4=>'至尊会员',5=>'私人定制'])->label('会员等级') ?>
    <?= $form->field($model, 'address')->dropDownList($areas, ['prompt'=>'---请选择地区---'])->label('地区') ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
