<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title='投诉';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Claims'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default">

    <div class="panel-heading"><h3 class="panel-title">会员投诉</h3></div>
    <div class="panel-body">

        <?php $form=ActiveForm::begin([
            'action'=>['/user/claims'],
            'method'=>'post',
            'options' => ['enctype' => 'multipart/form-data']
        ])?>

        <?=$form->field($model,'claims_to')->textInput(['maxlength'=>125,'onchange'=>'return check_name()','id'=>'user'])?>
        <div id="txtHint" class="text-danger"></div>
        <?=$form->field($model,'title')->textInput(['maxlength'=>125])?>
        <?=$form->field($model,'content')->textarea(['rows'=>5,'placeholder'=>'可以附上有力证据的网址链接'])?>
        <?=$form->field($model,'file')->fileInput()?>
        <?= Html::activeHiddenInput($model,'created_by',['value'=>Yii::$app->user->identity->username])?>
        <?= Html::activeHiddenInput($model,'created_at',['value'=>time()])?>


        <?= Html::submitButton('提交', ['class'=>'btn btn-primary','name' =>'submit-button']) ?>
        <?= Html::resetButton('重置', ['class'=>'btn btn-primary','name' =>'submit-button']) ?>

        <?php $form = ActiveForm::end()?>


    </div>

</div>

<script>

    function check_name(){

        var xhr = new XMLHttpRequest();


        xhr.onreadystatechange = function stateChanged()
        {
            if (xhr.readyState==4 || xhr.readyState=="complete")
            {
                document.getElementById("txtHint").innerHTML=xhr.responseText
            }
        };

        xhr.open('get','/index.php/user/claims/cname?user='+document.getElementById("user").value);

        xhr.send(null);

    }



</script>

