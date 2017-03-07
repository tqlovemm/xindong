<?php
use yii\web\View;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerJsFile("/js/jquery-1.11.3.js",['position' => View::POS_HEAD]);
/* @var $this yii\web\View */
/* @var $model backend\modules\dating\models\HeartweekSlideContent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="heartweek-slide-content-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->widget('shiyang\umeditor\UMeditor', [
        'clientOptions' => [
            'initialFrameHeight' => 100,
            'toolbar' => [
                'source | undo redo | bold italic underline strikethrough | superscript subscript | forecolor backcolor | removeformat |',
                'insertorderedlist insertunorderedlist | selectall cleardoc paragraph | fontfamily fontsize' ,
                '| justifyleft justifycenter justifyright justifyjustify |',
                'link unlink | emotion',
                '| preview fullscreen'
            ],
        ]
    ])->label('图片标题') ?>

    <div class="show-style"><img class="img-responsive img-thumbnail" src="<?=Yii::getAlias('@web')?>/images/style/style<?=$model->style?>.jpg"></div>
    <?=$form->field($model,'style')->dropDownList([
        0=>'无', 1=>'样式1', 2=>'样式2', 3=>'样式3', 4=>'样式4', 5=>'样式5', 6=>'样式6',7=>'样式7',8=>'样式8',
        9=>'样式9', 10=>'样式10', 11=>'样式11', 12=>'样式12', 13=>'样式13', 14=>'样式14', 15=>'样式15',16=>'样式16',17=>'样式17',
        18=>'样式18', 19=>'样式19', 20=>'样式20', 21=>'样式21', 22=>'样式22', 23=>'样式23', 24=>'样式24', 25=>'样式25',
        26=>'样式26', 27=>'样式27', 28=>'样式28（无样式）', 29=>'样式29', 30=>'样式30', 31=>'样式31', 32=>'样式32', 33=>'样式33',
    ])?>
    <?= $form->field($model, 'content')->widget('shiyang\umeditor\UMeditor', [
        'clientOptions' => [
            'initialFrameHeight' => 100,
            'toolbar' => [
                'source | undo redo | bold italic underline strikethrough | superscript subscript | forecolor backcolor | removeformat |',
                'insertorderedlist insertunorderedlist | selectall cleardoc paragraph | fontfamily fontsize' ,
                '| justifyleft justifycenter justifyright justifyjustify |',
                'link unlink | emotion',
                '| preview fullscreen'
            ],
        ]
    ])->label('图片内容') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <script>
        $('#heartweekslidecontent-style').on('change',function(){

            $('.show-style img').attr('src','<?=Yii::getAlias('@web')?>/images/style/style'+$('#heartweekslidecontent-style').val()+'.jpg');
        });

    </script>
</div>
