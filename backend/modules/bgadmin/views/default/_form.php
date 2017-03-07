<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    $datas = ['S'=>'S','A'=>'A','B'=>'B','C'=>'C'];
?>

<div class="bgadmin-member-form">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'sex')->dropDownList([0=>'男生',1=>'女生'],['prompt'=>'----请选择性别----']) ?>
    <?= $form->field($model, 'number')->textInput()->label('会员编号') ?>

    <?= $form->field($model, 'vip')->dropDownList([0=>'非会员',1=>'女生会员',2=>'普通会员',3=>'高端会员',4=>'至尊会员',5=>'私人定制'],['prompt'=>'----会员等级----']) ?>

    <?= $form->field($model, 'weicaht')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fantasies')->dropDownList($datas,['prompt'=>'----请选择颜值等级----'])->label('颜值') ?>

    <?= $form->field($model, 'credit')->dropDownList($datas,['prompt'=>'----请选择信用度等级----'])->label('信用度') ?>

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
<?php $this->registerJs("

    if($('#bgadminmember-sex').val()==1){
     $('.field-bgadminmember-fantasies').show();
            $('.field-bgadminmember-credit').show();
            $('.field-bgadminmember-fantasies').show();
            $('.field-bgadminmember-credit').show();
            $('.field-bgadminmember-number').hide();
    }else{
        $('.field-bgadminmember-number').show();
        $('.field-bgadminmember-fantasies').hide();
        $('.field-bgadminmember-credit').hide();
    }

    $('#bgadminmember-sex').change(function(){
        
        if($(this).val()==1){
            $('.field-bgadminmember-number').hide();
            $('#bgadminmember-vip').val(1);
            $('.field-bgadminmember-fantasies').show();
            $('.field-bgadminmember-credit').show();
 
        }else{
            $('.field-bgadminmember-number').show();
            $('.field-bgadminmember-fantasies').hide();
            $('.field-bgadminmember-credit').hide();

        }

    });
 
    
    $('#bgadminmember-fantasies,#bgadminmember-credit').change(function(){
        if($('#bgadminmember-fantasies').val()!=''&&$('#bgadminmember-credit').val()!=''){
        var jc_coin = $('#bgadminmember-fantasies').val()+$('#bgadminmember-credit').val();
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
            $('#bgadminmember-coin').val(coin);
        }
    });
    
")?>