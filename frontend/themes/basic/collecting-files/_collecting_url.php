<?php
$this->title = "普通会员入会生成链接";
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerCss('
    
    footer{display:none;}

');
?>
<div class="row text-center" style="background-color: #fff;padding:10px;">
    <a href="/collecting-files/info" class="btn btn-danger">等待审核</a>
</div>
<div class="setting-form" style="padding: 10px;">

    <?php $form = ActiveForm::begin();?>

    <?php
        if(in_array(Yii::$app->user->id,[13921])){
            echo $form->field($model, 'id')->textInput(['disabled'=>true])->label('admin_syn不可填写');
        }elseif(in_array(Yii::$app->user->id,[10000])){
            echo $form->field($model, 'id')->textInput()->label('会员编号，可不填，不填则由系统自动生成（建议新入会会员由系统自动生成，老会员自己填写）');
        }
    ?>
    <?= $form->field($model, 'sex')->dropDownList([0=>'男生',1=>'女生'])->label('性别') ?>
    <?= $form->field($model, 'address')->dropDownList($areas, ['prompt'=>'---请选择地区---'])->label('地区') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
