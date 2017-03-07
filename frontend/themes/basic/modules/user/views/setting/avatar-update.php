<?php
$this->title = "头像设置";
?>
<div class="form-group">
    <div class="fileupload fileupload-new">
        <div class="fileupload-new img-preview" style="width: 200px;height: 200px;margin: auto;">
            <img class="center-block" src="<?= $model->avatar ?>">
        </div>
    </div>

    <!-- <div class="col-md-6">
            <div class="fileupload fileupload-new">
                <div class="img-preview"></div>
            </div>
        </div>-->
</div>
<div class="clearfix"></div>
<div class="form-group"><?= \shiyang\webuploader\Cropper::widget() ?></div>

