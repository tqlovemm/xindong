<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $model backend\modules\seventeen\models\SeventeenWeiUser */
/* @var $form yii\widgets\ActiveForm */
$areas_all = array();
$areas_all = implode('，',$areas);
?>
<?php $this->registerJsFile("/js/jquery-1.11.3.js",['position' => View::POS_HEAD]);?>
<div class="seventeen-wei-user-form">
    <?php $form = ActiveForm::begin(); ?>
<hr>
    <?= $form->field($model, 'address')->textarea(['maxlength' => false])->label("会员地区【可以帮会员修改或添加其他地区，（<span style='color:red;'>直接复制上面的地区连带后面的中文逗号，不要有空格</span>）】") ?>
    <?= $form->field($model, 'status')->dropDownList([0=>'禁用',1=>'限时',2=>'永久'])->label("使用状态（<span style='color:red;'>如果为限时请在下方填写时间，禁用和永久可不填</span>）") ?>
    <?= $form->field($model, 'expire')->textInput()->label("请输入限时时间（<span style='color:red;'>小时</span>）") ?>
    <div id="all_label" style="padding: 10px 0;">
        <?php foreach ($areas as $area):?>
            <span class="single-area" onclick="add_area(this)" style="background-color: #0d4aff;border: none;display:inline-block;margin-bottom: 5px;padding:2px 5px;color:#fff;cursor: pointer;white-space:nowrap;"><?=$area?></span>
        <?php endforeach;?>
        <span onclick="add_area_all(this)" id="all_area" data-area-all = "<?=$areas_all?>" style="background-color: #ff0c13;border: none;display:inline-block;margin-bottom: 5px;padding:2px 10px;color:#fff;cursor: pointer;white-space:nowrap;">全部</span>
    </div>
    <div class="form-group ">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<script>

    function add_area(con) {
        var span = $(con);
        var address_content = $('#seventeenweiuser-address');
        var all = $('#all_area').attr('data-area-all');
        $('#seventeenweiuser-address').html(address_content.html()+span.html()+'，');
        $('#all_area').attr('data-area-all',all.replace(span.html()+'，',''));
        span.remove();
        if($('#all_label').children('.single-area').length==0){
            $('#all_area').remove();
        }
    }

    function add_area_all(con) {
        var span = $(con);
        var address_content = $('#seventeenweiuser-address');
        $('#seventeenweiuser-address').html(address_content.html()+span.attr('data-area-all')+'，');
        $("#all_label").remove();
    }

    $(function () {
        if($('#all_area').attr('data-area-all')==''){
            $('#all_area').remove();
        }
    });

</script>
