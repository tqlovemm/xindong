<?php

    use yii\widgets\ActiveForm;
    use yii\myhelper\Helper;
    use yii\helpers\Html;
    $this->registerCss('
        html,body{overflow-y: auto;}
        .navbar-default,.navbar-header,footer{display:none;}
        .col-xs-10 img{width:70px;height:60px;}
    ');


?>

<div class="row">
<div  style="background-color: white;" class="center-block col-xs-12">
    <div class="content-warning clearfix">
        <h5>您举报的是:</h5>
        <div class="row">
            <div class="col-xs-2"><img class="img-circle" style="width: 50px;" src="<?= $user['avatar']?>"></div>
            <div class="col-xs-10">
                <span>
                    <strong><a class="text-danger" href="/index.php/u/<?=$user['username']?>" target="_blank"><?=$user['username']?></a></strong>
                </span>的论坛发帖：
                <p style="background-color: #c7c7c7;padding:2px;">
                    <?=Helper::truncate_utf8_string($content['content'],40)?>

                    <div class="clearfix"></div>
                    <?php $m_images = json_decode($content['image_path']);if(!empty($m_images)): for($i=0;$i<count($m_images);$i++):?>
                        <img class="img-thumbnail" src="<?=$m_images[$i]?>">
                    <?php endfor; endif; ?>
                </p>
            </div>
        </div>
    </div>
    <?php
    $claims = array(
        '垃圾营销'=>'垃圾营销',
        '淫秽色情'=>'淫秽色情',
        '抄袭我的内容'=>'抄袭我的内容',
        '违法信息'=>'违法信息',
        '不实信息'=>'不实信息',
        '人身攻击我'=>'人身攻击我');


    $form = ActiveForm::begin(['action' => ['user-claims/index'],'method'=>'post',]); ?>

    <?= $form->field($model, 'content')->radioList($claims)->label('请选择举报类型：') ?>
    <?= $form->field($model, 'user_id')->hiddenInput(['value'=>Yii::$app->user->id])->label(false) ?>
    <?= $form->field($model,'description')->textInput()->label('添加描述：')?>
    <?= $form->field($model, 'created_at')->hiddenInput(['value'=>time()])->label(false) ?>
    <?= $form->field($model, 'thread_id')->hiddenInput(['value'=>$content['id']])->label(false) ?>
    <?= Html::submitButton('提交', ['class'=>'btn btn-primary pull-right']) ?>

    <?php ActiveForm::end(); ?>

</div>

</div>