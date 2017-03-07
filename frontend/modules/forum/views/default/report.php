<?php

$this->title = "我要举报";
$this->registerCss('
    .threadInfo img{width:45px;display:inline;}
    .report{background-color:#fff;padding:10px 15px;}
    .container-fluid{padding:0;}
    .row{width:100%;height:35px;line-height:35px;background-color:black;color:#fff;font-size:14px;margin:0;}

');

?>
<div class="row">
    <div class="col-xs-2" style="padding-left: 0px;height:35px;line-height:35px;"><a href="javascript:history.back();"><img  style="width: 25px;" src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></a></div>
    <div class="col-xs-8" style="text-align: center"><?=$this->title?></div>
    <div class="col-xs-2" style="padding-right: 10px;"><a href="/forum/default" style="color: #fff;">主页</a></div>
</div>
<div class="report">
    <div style="padding: 10px 0;">您要举报的帖子：</div>
    <div class="threadInfo">
        <img class="img-responsive img-circle" src="<?=$user['headimgurl']?>">
        <span style="padding-left: 5px;"><?=$user['username']?></span>
    </div>
    <div style="padding: 5px 0;"><?=$thread['content']?></div>

    <div style="padding-top:15px;">
        <dl class="mycontent" <?php if(isset($exist) && !empty($exist)){echo 'style="display:none"';}?>>
            <dt style="padding: 5px 0; font-size: 16px;">举报理由：</dt>

            <dd><input type="checkbox" name="check" value="内容或图片涉黄">&nbsp;&nbsp;内容或图片涉黄</dd>
            <dd><input type="checkbox" name="check" value="侵犯个人隐私或权益">&nbsp;&nbsp;侵犯个人隐私或权益</dd>
            <dd><input type="checkbox" name="check" value="人身攻击">&nbsp;&nbsp;人身攻击</dd>
            <dd><input type="checkbox" name="check" value="发广告">&nbsp;&nbsp;发广告</dd>
            <dd><input type="checkbox" name="check" value="传播不法信息">&nbsp;&nbsp;传播不法信息</dd>
            <dd><input type="checkbox" name="check" value="存在诈骗行为">&nbsp;&nbsp;存在诈骗行为</dd>
            <dd style="color:orange;font-size: 12px;padding: 8px 0;">其他原因（请联系客服解决）</dd>
            <dd><input type="button" class="btn btn-primary" name="button" value="举报" style="width: 80px;" onclick="report(<?=$thread['tid']?>)"</dd>
        </dl>
        <?php if(isset($exist) && !empty($exist)):?>
        <div class="res" style="color: orange">您举报过了</div>
        <?php endif;?>
        <div class="res2" style="color: orange"></div>
    </div>
</div>
<script>

 function report(tid){

     var chc_value = [];
     $('input[name="check"]:checked').each(function(){
         chc_value.push($(this).val());
     });
     if(chc_value.length == 0){
        alert('您还没有选择举报内容');return ;
     }
     if(confirm('确定要举报吗')){
         $.post('/forum/default/report',{tid:tid,content:chc_value.join()},function(result){
             $('.mycontent').css({"display":"none"});
             $('.res2').html(result);
         });
     }


 }
</script>