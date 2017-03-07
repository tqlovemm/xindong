<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerCss("
    .distpicker .form-control{width: 200px;float: left;margin-right:15px;}
");
$id = Yii::$app->request->get('id');
$address_1 = (!empty($model->address_1))?json_decode($model->address_1,true):array('province'=>'---- 所在省 ----','city'=>'---- 所在市 ----');
$address_2 = (!empty($model->address_2))?json_decode($model->address_2,true):array('province'=>'---- 所在省 ----','city'=>'---- 所在市 ----');
$address_3 = (!empty($model->address_3))?json_decode($model->address_3,true):array('province'=>'---- 所在省 ----','city'=>'---- 所在市 ----');
?>

<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php echo $form->field($model, 'number')->textInput() ?>
    <label>地区一</label>
    <div class="distpicker" data-toggle="distpicker">
        <div id="address_1" class="form-group clearfix">
            <select class="form-control" name="province1"></select>
            <select class="form-control" name="city1"></select>
        </div>
    </div>
    <label>地区二</label>
    <div class="distpicker" data-toggle="distpicker">
        <div id="address_2" class="form-group clearfix">
            <select class="form-control" name="province2"></select>
            <select class="form-control" name="city2"></select>
        </div>
    </div>
    <label>地区三</label>
    <div class="distpicker" data-toggle="distpicker">
        <div id="address_3" class="form-group clearfix">
            <select class="form-control" name="province3"></select>
            <select class="form-control" name="city3"></select>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$this->registerJs("

    $('#address_1').distpicker({
        province: '$address_1[province]',
        city: '$address_1[city]',
    });  
    
    $('#address_2').distpicker({
        province: '$address_2[province]',
        city: '$address_2[city]',
    });  
    
    $('#address_3').distpicker({
        province: '$address_3[province]',
        city: '$address_3[city]',
    });
");
?>

