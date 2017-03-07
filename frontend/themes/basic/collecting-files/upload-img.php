<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/27
 * Time: 15:11
 */
?>

<?php $this->registerJsFile('js/jquery.wallform.js', ['depends' => ['frontend\assets\AppAsset'], 'position' => $this::POS_HEAD]); ?>
<script type="text/javascript" src="http://libs.useso.com/js/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.wallform.js"></script>


<div id="main" style="padding:10px;background-color: #fbf9fe;">
<form id="imageform" method="post" enctype="multipart/form-data" action="/collecting-files/upload">

    <div id="up_status" style="display:none"><img src="/images/loader.gif" alt="uploading"/></div>
    <div id="up_btn" class="btn">
        <span>添加档案图片</span>
        <input id="photoimg" type="file" name="photoimg">
    </div>
</form>
<p>最大2MB，支持jpg，gif，png格式。</p>
<div id="preview"></div>
</div>

<script>

    $(function () {
        $('#photoimg').die('click').live('change', function(){
            var status = $('#up_status');
            var btn = $('#up_btn');
            $('#imageform').ajaxForm({
                target: '#preview',
                beforeSubmit:function(){
                    status.show();
                    btn.hide();
                },
                success:function(){
                    status.hide();
                    if( $('#preview img').size()==5 ){
                        btn.hide();
                    }else {
                        btn.show();
                    }
                },
                error:function(){
                    status.hide();
                    btn.show();
                } }).submit();
        });

    });


</script>