<div class="container">
    <div class="row">
        <div class="col-md-5 col-md-offset-3">
            <h1>会员编号：<?=$model->id?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-md-offset-3">
            <textarea id="copy_url" class="form-control text-center"><?=$url?>?flag=<?=$model->flag?></textarea>
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