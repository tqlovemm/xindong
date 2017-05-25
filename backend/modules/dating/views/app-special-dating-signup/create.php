<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\dating\models\AppSpecialDating */
/* @var $form ActiveForm */
?>
<div class="create row">
    <div class="col-md-8">
        <div class="box box-warning" style="padding: 10px;">
            <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'p_info')->textInput(['placeholder'=>'标签形式，不同标签之间英文逗号隔开']) ?>
                <?= $form->field($model, 'h_info')->textInput(['placeholder'=>'标签形式，不同标签之间英文逗号隔开']) ?>
                <?= $form->field($model, 'wechat')->textInput(['placeholder'=>'专属女生微信号']) ?>
                <?= $form->field($model, 'introduce')->textarea(['placeholder'=>'女生简介']) ?>
                <?= $form->field($model, 'coin')->textInput(['type'=>'number']) ?>
                <?= $form->field($model, 'limit_count')->textInput(['type'=>'number']) ?>
                <?= $form->field($model, 'limit_vip')->dropDownList([4=>"至尊及以上会员",2=>"普通及以上会员",3=>"高端及以上会员",5=>"私人定制"]) ?>
                <?= $form->field($model, 'status')->dropDownList([10=>'发布',0=>'不发布']) ?>
                <?= $form->field($model, 'authenticate')->dropDownList([10=>'认证',0=>'非认证']) ?>
                <?= $form->field($model, 'tag_type')->dropDownList([0=>'无',1=>'HOT']) ?>
                <?= $form->field($model, 'contact_model')->dropDownList([1=>'微信号获取']) ?>
                <?= $form->field($model, 'address')->dropDownList($province) ?>
                <?= $form->field($model, 'address_detail') ?>
                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div><!-- create -->