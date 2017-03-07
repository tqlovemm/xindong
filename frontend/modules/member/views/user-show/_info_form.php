<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
$this->title = "会员完善信息";
$this->registerCss("

    .info_form .help-block{display:none;}

");

?>
<?php $this->registerJsFile("@web/js/jquery-1.11.3.js",['position' => View::POS_HEAD]);?>
<div class="info_form" style="padding: 0 15px;">

    <?php $form = ActiveForm::begin([
        'method'=>'post',
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

        <?= $form->field($model, 'weichat') ?>
        <?= $form->field($model, 'weibo') ?>
        <?= $form->field($model,'country')->dropDownList($model->getCityList(-1),
            [
                'prompt'=>'--请选择国家--',
                'onchange'=>'

                if($(\'#userprofile-country\').val()==0){
                $.post("/member/site?typeid=0&pid="+$(this).val(),function(data){

                     $(\'.field-userprofile-province,.field-userprofile-city,.field-userprofile-area\').show();

                    $("select#userprofile-province").val(data);

                });}else{
                    $(\'#userprofile-province,#userprofile-city,#userprofile-area\').val("");
                    $(\'.field-userprofile-province,.field-userprofile-city,.field-userprofile-area\').hide();


                }

                ',
            ]) ?>

        <?= $form->field($model,'province')->dropDownList($model->getCityList($model->country),
        [
            'prompt'=>'--请选择省--',
            'onchange'=>'
            $(".form-group.field-member-area").show();
            $.post("/member/site?typeid=1&pid="+$(this).val(),function(data){
                $("select#userprofile-city").html(data);
            });',
        ]) ?>

        <?= $form->field($model, 'city')->dropDownList($model->getCityList($model->province),
        [
            'prompt'=>'--请选择市--',
            'onchange'=>'
            $(".form-group.field-member-area").show();
            $.post("/member/site?typeid=2&pid="+$(this).val(),function(data){
                $("select#userprofile-area").html(data);
            });',
        ]) ?>
        <?= $form->field($model, 'area')->dropDownList($model->getCityList($model->city),['prompt'=>'--请选择区--',]) ?>

        <div class="form-group">
            <?= Html::submitButton('确定', ['class' => 'btn btn-primary', 'style'=>'border-color:#E83F78;background-color:#E83F78;width:100%;padding: 5px 0;font-size:20px;',]) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div><!-- _info_form -->
