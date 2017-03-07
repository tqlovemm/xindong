<?php
    $this->title = '女生资料收集链接';
?>
<div class="container">
    <div class="row">
        <div class="col-md-5 col-md-offset-3">
            <h1>女生链接：<?=$model->id?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-md-offset-3">
            <textarea title="cctv" id="copy_url" class="form-control text-center">http://13loveme.com/bgadmin?flag=<?=$model->flag?></textarea>
            <div class="btn btn-primary pull-right" onclick="jsCopy()">复制</div>
        </div>
    </div>
</div>

<script>
    function jsCopy(){
        var e=document.getElementById("copy_url");//对象是content
        e.select(); //选择对象
        document.execCommand("Copy"); //执行浏览器复制命令
        alert("已复制好，可贴粘。");
    }
</script>