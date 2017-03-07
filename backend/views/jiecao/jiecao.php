<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>


<?php if(!empty($jiecao)):
    foreach($jiecao as $item):
    ?>
    <div style="padding:5px 10px;border: 2px solid red;margin-bottom: 10px;">
        <h4>ID:<?=$item['id']?></h4>
        <h4>会员名:<?=$item['username']?></h4>
    </div>

<?php
    endforeach;
    endif;
?>
<?php $form=ActiveForm::begin();?>
<?=$form->field($profile,'number')->textInput()->label('会员编号')?>
<div class="form-group">
    <?= Html::submitButton('输入会员编号先查询会员ID', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end();?>


<div class="jiecao">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'user_id')->label('会员ID') ?>
        <?= $form->field($model, 'value')->label('节操币数量') ?>
        <?= $form->field($model, 'reason')->label('操作原因') ?>
        <?= $form->field($model, 'type')->dropDownList([0=>'扣除节操币'])->label('类型') ?>
        <?= $form->field($model, 'where')->label('地区') ?>
        <?= $form->field($model, 'number_info')->label('编号信息') ?>
        <?php $model->expire = 5?>
        <?= $form->field($model, 'expire')->label('冻结时间（default  5 hour）') ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div><!-- jiecao -->
