<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<style>
    #success {
        line-height: 30px;
        height: 30px;
        margin: 20px 0 0 0;
    }
    #success div {
        padding-left: 24px;
    }
    .alert-success {
        color: #3c763d;
        background-color: #dff0d8;
        border-color: #d6e9c6;
    }
</style>
<div class="article-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label("标题") ?>
    <?= $form->field($model, 'miaoshu')->textInput(['maxlength' => true])->label("描述") ?>
    <div class="form-group field-article-wimg required">
        <label class="control-label" for="article-wimg">描述图片</label>
        <input type="file" id="article-wimg" name="wimg">

        <div class="help-block"></div>
    </div>

    <div class="form-group field-article-wimg required">
        <label class="control-label" for="article-wimg">视频（可不传）</label>
        <div id="container">
            <a class="btn btn-default btn-lg " id="pickfiles" href="#" >
                <i class="glyphicon glyphicon-plus"></i>
                <span>选择文件</span>
            </a>
        </div>

        <div style="display:none" id="success" class="col-md-12">
            <div class="alert-success">
                队列全部文件处理完毕
            </div>
        </div>
        <div class="col-md-12 ">
            <table class="table table-striped table-hover text-left"   style="display:none">
                <thead>
                <tr>
                    <th class="col-md-4">Filename</th>
                    <th class="col-md-2">Size</th>
                    <th class="col-md-6">Detail</th>
                </tr>
                </thead>
                <tbody id="fsUploadProgress">
                </tbody>
            </table>
        </div>
        <div class="help-block"></div>
    </div>

    <?= $form->field($model, 'wtype')->textInput()->dropDownList($type) ?>
    <?= $form->field($model, 'wlabel')->textInput()->dropDownList($label) ?>
    <?= $form->field($model,'content')->label("内容")->widget('common\widgets\ueditor\Ueditor',[
        'options'=>[
            'initialFrameHeight' => 300,
            'lang' =>'zh-cn',
        ]
    ]) ?>


    <?= $form->field($model, 'wclick')->textInput()->label("点击数") ?>

    <?= $form->field($model, 'wdianzan')->textInput()->label("点赞数") ?>

    <?= $form->field($model, 'hot')->textInput()->dropDownList([1=>'推荐',2=>'非推荐']) ?>
    <?= $form->field($model, 'yuanchuang')->textInput()->dropDownList([1=>'原创',2=>'非原创']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?=Html::jsFile('@web/css/article/jquery.min.js')?>
<?=Html::jsFile('@web/css/article/plupload.full.min.js')?>
<?=Html::jsFile('@web/css/article/qiniu.min.js')?>
<?=Html::jsFile('@web/css/article/ui.js')?>
<script type="text/javascript">
    $(function() {
        var uploader = Qiniu.uploader({
            runtimes: 'html5,flash,html4',
            browse_button: 'pickfiles',
            container: 'container',
            drop_element: 'container',
            max_file_size: '1000mb',
            flash_swf_url: 'bower_components/plupload/js/Moxie.swf',
            dragdrop: true,
            chunk_size: '4mb',
            multi_selection: !(mOxie.Env.OS.toLowerCase()==="ios"),
            uptoken_url: '/article/article/gettoken',
            // uptoken_func: function(){
            //     var ajax = new XMLHttpRequest();
            //     ajax.open('GET', $('#uptoken_url').val(), false);
            //     ajax.setRequestHeader("If-Modified-Since", "0");
            //     ajax.send();
            //     if (ajax.status === 200) {
            //         var res = JSON.parse(ajax.responseText);
            //         console.log('custom uptoken_func:' + res.uptoken);
            //         return res.uptoken;
            //     } else {
            //         console.log('custom uptoken_func err');
            //         return '';
            //     }
            // },
            domain: "http://omsnqyd5g.bkt.clouddn.com/",
            get_new_uptoken: false,
            // downtoken_url: '/downtoken',
             unique_names: false,
             save_key: false,
            // x_vars: {
            //     'id': '1234',
            //     'time': function(up, file) {
            //         var time = (new Date()).getTime();
            //         // do something with 'time'
            //         return time;
            //     },
            // },
            auto_start: true,
            log_level: 5,
            init: {
                'FilesAdded': function(up, files) {
                    $('table').show();
                    $('#success').hide();
                    plupload.each(files, function(file) {
                        var progress = new FileProgress(file, 'fsUploadProgress');
                        progress.setStatus("等待...");
                        progress.bindUploadCancel(up);
                    });
                },
                'BeforeUpload': function(up, file) {
                    var progress = new FileProgress(file, 'fsUploadProgress');
                    var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                    if (up.runtime === 'html5' && chunk_size) {
                        progress.setChunkProgess(chunk_size);
                    }
                },
                'UploadProgress': function(up, file) {
                    var progress = new FileProgress(file, 'fsUploadProgress');
                    var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                    progress.setProgress(file.percent + "%", file.speed, chunk_size);
                },
                'UploadComplete': function() {
                    $('#success').show();
                },
                'FileUploaded': function(up, file, info) {
                    var progress = new FileProgress(file, 'fsUploadProgress');
                    progress.setComplete(up, info);
                },
                'Error': function(up, err, errTip) {
                    $('table').show();
                    var progress = new FileProgress(err.file, 'fsUploadProgress');
                    progress.setError();
                    progress.setStatus(errTip);
                }
                 ,
                 'Key': function(up, file) {
                     var mydate = new Date();
                     var Y = mydate.getFullYear();
                     var m = mydate.getMonth()+1;
                     var d = mydate.getDate();
                     if(m <10){
                         m = "0"+m;
                     }
                     if(d<10){
                         d = "0"+d;
                     }
                     var ext = Qiniu.getFileExtension(file.name);
                     var key = Y+'/'+m+'/'+d+'/'+guid()+'.' + ext;
                     return key;
                 }
            }
        });
    });
    function S4() {
        return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
    }
    function guid() {
        return (S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4());
    }
</script>
