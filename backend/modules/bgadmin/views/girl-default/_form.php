<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    $datas = ['S'=>'S','A'=>'A','B'=>'B','C'=>'C'];
    $pre_url = Yii::$app->params['shisangirl'];
?>

<div class="bgadmin-member-form">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'sex')->dropDownList([1=>'女生']) ?>

    <?= $form->field($model, 'number')->textInput()->label('会员编号') ?>

    <?= $form->field($model, 'vip')->dropDownList([1=>'女生会员']) ?>

    <?= $form->field($model, 'weicaht')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fantasies')->dropDownList($datas,['prompt'=>'----请选择颜值等级----'])->label('颜值') ?>

    <?= $form->field($model, 'credit')->dropDownList($datas,['prompt'=>'----请选择信用度等级----'])->label('信用度') ?>

    <?= $form->field($model, 'weibo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cellphone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_a')->dropDownList($area,['prompt'=>'----请选择地区----']) ?>

    <?= $form->field($model, 'address_b')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'cup')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'height')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'hobby')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'age')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'like_type')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'coin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'foreign')->dropDownList([0=>'公开',1=>'打码'])->label('照片是否公开') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['id'=>'create_success','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div class="row">
    <?php
        $r = \backend\modules\weekly\models\Weekly::findOne(['flag'=>$model->flag]);
        $weeklyModel =!empty($r)?$r:\backend\modules\weekly\models\Weekly::findOne($model->member_id);
        if(!empty($weeklyModel)):
        $photos = $weeklyModel->getPhotos();
        foreach ($photos['photos'] as $photo):?>
            <div class="col-md-2"><img class="img-responsive" src="<?=$pre_url.$photo['path']?>"></div>
        <?php endforeach;endif;?>
</div>
<?php

if($model->isNewRecord||empty($model->number)){
    $this->registerJs("
       setTimeout(function(){
        $.get('get-girl-number',function(data){
            
            $('#bgadmingirlmember-number').val(data);
        });
    },500);
    ");
}
$this->registerJs("
    $('#bgadmingirlmember-fantasies,#bgadmingirlmember-credit').change(function(){
        if($('#bgadmingirlmember-fantasies').val()!=''&&$('#bgadmingirlmember-credit').val()!=''){
        var jc_coin = $('#bgadmingirlmember-fantasies').val()+$('#bgadmingirlmember-credit').val();
         switch (jc_coin){
            case 'SS':coin = 150;break;
            case 'AS':
            case 'SA':coin = 100;break;
            case 'SB':
            case 'AA':
            case 'BS':coin = 80;break;
            case 'AB':
            case 'BA':
            case 'CS':coin = 60;break;
            case 'SC':coin = 50;break;
            case 'AC':
            case 'BB':
            case 'CA':coin = 40;break;
            case 'BC':
            case 'CB':coin = 30;break;
            case 'CC':coin = 20;break;
            default:coin = 0;
        }
            $('#bgadmingirlmember-coin').val(coin);
        }
    });
")?>