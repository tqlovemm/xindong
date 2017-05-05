<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "修改会员链接信息";
$vips = [2=>'普通会员',3=>'高端会员',4=>'至尊会员',5=>'私人定制',1=>'网站会员'];
?>
<p>
    <?= Html::a('创建会员链接', ['create'], ['class' => 'btn btn-primary']) ?>
</p>
<div class="row">
    <div class="col-md-6">
        <div class="send_url_form box box-danger" style="padding: 10px;">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'id')->textInput(['disabled'=>true])->label('会员编号') ?>
            <?= $form->field($model, 'vip')->dropDownList($vips)->label('会员等级') ?>
            <?= $form->field($model, 'province')->dropDownList($province)->label('入会地区') ?>
            <?= $form->field($model, 'coin')->textInput(['type'=>'number'])->label('初始节操币') ?>
            <?= $form->field($model, 'flag')->textarea(['disabled'=>true])->label('链接') ?>
            <div class="form-group">
                <?= Html::submitButton('修改', ['class' => 'btn btn-danger']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div><!-- _send_url_form -->
    </div>
</div>
