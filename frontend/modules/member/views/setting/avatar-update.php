<?php
$this->title = "档案照";
$this->registerCssFile('@web/js/lightbox/css/lightbox.css');
$this->registerJsFile('@web/js/lightbox/js/lightbox.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);
?>
<div class="row member-center form-group">
    <header>
        <div class="header">
            <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
            <h2 style="margin:0;"><?=$this->title?></h2>
        </div>
    </header>
</div>

<div class="form-group" style="background-color: #fff;">
    <h5 style="padding:10px;line-height: 20px;color:gray;">档案照建议为正方形，大小不超过2MB，为了确保审核通过请用本人真实生活照。<br><span style="color:#ff5d5b;">您的档案照将会在您报名觅约后直接展示给您报名的女生看哦</span></h5>
    <div class="fileupload fileupload-new" style="padding-bottom:1px;">
        <div class="fileupload-new img-preview text-center" style="width: 260px;height:260px;margin:10px auto; line-height: 260px;">
            <?php if(empty($model->file_1)):?>
                <span class="glyphicon glyphicon-plus" style="font-size: 50px;color: grey;"></span>
            <?php else:
                if($status==5):?>
                    <span style="font-size: 50px;color: grey;">审核中</span>
                <?php elseif($status==0):?>
                    <span style="font-size:20px;color: grey;">审核不通过请重新提交</span>
                <?php else:?>
                <a href="<?=$model->file_1 ?>" data-title="<?=$model->number?>" data-lightbox="file" >
                    <img class="center-block img-responsive center-block" style="box-shadow: 0 0 10px #f3f3f3;width: 100%;" src="<?=$model->file_1?>">
                </a>
                <?php endif;endif;?>

        </div>
    </div>
    <!-- <div class="col-md-6">
            <div class="fileupload fileupload-new">
                <div class="img-preview"></div>
            </div>
        </div>-->
</div>
<div class="form-group text-center" style="background-color: #fff;padding:10px 0 5px;">
    <?= \shiyang\webuploader\Cropper::widget() ?>
</div>
<?php
    $this->registerJs("

        $('.webuploader-pick').html('上传档案照');

        $('.glyphicon-plus').click(function(){

            $('.webuploader-element-invisible').trigger('click');
        });

    ");
?>
