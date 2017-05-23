<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
if($model->status==10){
$this->registerCss("
.field-websitecontent-start_time,.field-websitecontent-end_time{display:none;}
");
}
?>

<div class="weekly-content-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('标题') ?>
    <?= $form->field($model, 'status')->dropDownList([10=>'全天',0=>'选择时间段'])->label('时间段') ?>
    <?= $form->field($model, 'start_time')->dropDownList($arr, [
        'prompt'=>'---请选择开始时间---',
        'onchange'=>'$.post("lists?id='.'"+$(this).val(),function(data){
                $("select#websitecontent-end_time").html(data);
            });',
    ])->label('开始时间') ?>
    <?= $form->field($model, 'end_time')->dropDownList($end_time,['prompt'=>'---请选择结束时间---'])->label('结束时间') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php

$this->registerJs("

  $('#websitecontent-status').change(function () {

            if($(this).val()==0){
                $(\".field-websitecontent-start_time,.field-websitecontent-end_time\").show();
            }else {
                $(\".field-websitecontent-start_time,.field-websitecontent-end_time\").hide();
            }
        });

");

?>
