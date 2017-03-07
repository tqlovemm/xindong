<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\user\models\Mark;
use yii\helpers\ArrayHelper;


$this->title = "标签";
$mark=Mark::find()->all();

$listData1=array_filter(ArrayHelper::map($mark,'mark_name','mark_name'));
$listData2=array_filter(ArrayHelper::map($mark,'make_friend_name','make_friend_name'));
$listData3=array_filter(ArrayHelper::map($mark,'hobby_name','hobby_name'));

$this->registerCssFile("@web/css/fm.selectator.jquery.css");
$this->registerCss("

    #selectator_select6,#selectator_select7,#selectator_select8{border-radius:5px;}
");
?>
<div class="row member-center">
    <header>
        <div class="header">
            <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
            <h2 style="margin:0;"><?=$this->title?></h2>
        </div>
    </header>
</div>
        <?php $form = ActiveForm::begin(); ?>

        <div class="mark-friend-hobby">
            <h5>我的标签：</h5>
            <div class="row" style="margin: 10px 0;">
                <?php
                if(!empty(json_decode($profile->mark))):
                foreach(json_decode($profile->mark) as $item):?>
                    <span style="padding: 2px 5px;background-color: #39f;color:#fff;border-radius: 3px;"><?=$item?></span>
                <?php endforeach;endif;?>
            </div>
            <?= $form->field($profile, 'mark')->dropDownList($listData1,['id'=>'select6',
                'class'=>'form-control','multiple'=>true,'style'=>"height:34px;"
            ])->label(false) ?>
            <input value="activate selectator" class="hidden activate_mark"  type="button">
        </div>

        <div class="mark-friend-hobby">
            <h5>交友要求：</h5>
            <div class="row" style="margin: 10px 0;">
                <?php
                if(!empty(json_decode($profile->make_friend))):
                foreach(json_decode($profile->make_friend) as $item):?>
                    <span style="padding: 2px 5px;background-color: #EFCF1E;color:#fff;border-radius: 3px;"><?=$item?></span>
                <?php endforeach;endif;?>
            </div>
            <?= $form->field($profile, 'make_friend')->dropDownList($listData2,['id'=>'select7',
                'class'=>'form-control','multiple'=>true,'style'=>"height:34px;"
            ])->label(false) ?>
            <input value="activate selectator" class="hidden activate_friend"  type="button">
        </div>

        <div class="mark-friend-hobby">
            <h5>兴趣爱好：</h5>
            <div class="row" style="margin: 10px 0;">
                <?php
                if(!empty(json_decode($profile->hobby))):
                foreach(json_decode($profile->hobby) as $item):?>
                    <span style="padding: 2px 5px;background-color: #EF64E3;color:#fff;border-radius: 3px;"><?=$item?></span>
                <?php endforeach;endif;?>
            </div>
            <?= $form->field($profile, 'hobby')->dropDownList($listData3,['id'=>'select8',
                'class'=>'form-control','multiple'=>true,'style'=>"height:34px;"
            ])->label(false) ?>
            <input value="activate selectator" class="hidden activate_hobby"  type="button">

        </div>

        <div class="form-group">
            <?= Html::submitButton('保存', ['class' => 'btn btn-warning','style'=>'width:100%;']) ?>
        </div>

        <?php ActiveForm::end();

            $this->registerJs("

            var activate_mark = $('.activate_mark');
           activate_mark.click(function () {
                var select6 = $('#select6');
                if (select6.data('selectator') === undefined) {
                    select6.selectator({
                        showAllOptionsOnFocus: true,
                        keepOpen: true
                    });
                    activate_mark.val('destroy selectator');
                } else {
                    select6.selectator('destroy');
                    activate_mark.val('activate selectator');
                }
            });
            activate_mark.trigger('click');
            var activate_friend = $('.activate_friend');
             activate_friend.click(function () {
                var select7 = $('#select7');
                if (select7.data('selectator') === undefined) {
                    select7.selectator({
                        showAllOptionsOnFocus: true,
                        keepOpen: true
                    });
                    activate_friend.val('destroy selectator');
                } else {
                    select7.selectator('destroy');
                    activate_friend.val('activate selectator');
                }
            });
            activate_friend.trigger('click');

            var activate_hobby = $('.activate_hobby');
            activate_hobby.click(function () {
                var select8 = $('#select8');
                if (select8.data('selectator') === undefined) {
                    select8.selectator({
                        showAllOptionsOnFocus: true,
                        keepOpen: true
                    });
                    activate_hobby.val('destroy selectator');
                } else {
                    select8.selectator('destroy');
                    activate_hobby.val('activate selectator');
                }
            });
            activate_hobby.trigger('click');

            ");
        ?>

