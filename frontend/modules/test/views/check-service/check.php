<?php

$this->title = "客服微信号查询";
$this->registerCss('
    .container-fluid{padding:0;margin:0;}
    #mysreach{background-color: #fff;margin: 10px auto 0;padding:40px 0 60px;}
    .searchfor{
        color:#EC5B8B;
        font-size:20px;
        font-weight:bold;
        margin-bottom:30px;
        }

');
?>
<div class="wrap">
    <div class="container-fluid">
        <div class="center-block" style="background-color: black;height: 35px;line-height: 35px;">
            <div><!--
                <a href="javascript:history.go(-1)" style="color: #fff;padding-left: 10px;">返回</a>-->
                <a href="/" style="color: #fff;padding-left: 10px;">首页</a>
            </div>
        </div>
    </div>
</div>
<div class="text-center" id="mysreach">
    <div class="searchfor">官方客服微信号防伪查询</div>
    <form class="check-form" style="padding: 0 10px;" name="myform" action="index" method="post">
        <input type="text" id="number" name="number" class="form-control" style="width: 65%;display: inline;border: 1px solid #eee;" placeholder="输入你要查询的客服微信编号" required>
        <img src="/images/check/discove.png" style="height:42px;" onclick="search()">
    </form>
    <div id="mycheck" style="display: none">
        <span>警告：客服编号不能为空</span>
        <span><a href="javascript:;" class="">确定</a></span>
    </div>
</div>
<script>
   function search(){
       if($('#number').val()==''){
           alert('客服号不可为空');
           $('#number').focus();
           return false;
       }
       document.myform.submit();
   }
</script>

