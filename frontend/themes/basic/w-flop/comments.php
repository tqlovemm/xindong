<?php
if(empty($openid)){
    $openid = Yii::$app->request->get('openid');
}

$title = '评论';
$this->registerCss("
   .navbar,footer,.weibo-share{display:none;}
   body,.dated-comments{background-color:#fff;height:100%;}
   .dated-comments .row{margin:0;padding:10px;}
   .dated-comments .row .title{font-size:20px;}
   .dated-comments form .col-xs-2{font-size:22px;padding:0;text-align:center;}
   .dated-comments form .col-xs-5{padding:0;}
   .dated-comments form .col-xs-3{padding:0;}
   .dated-comments form .col-xs-10{padding:0;}
    label{margin-bottom:0;}
");
?>

<div class="dated-comments" style="margin-bottom: 100px;">
    <div class="row">
        <div class="title clearfix" style="position: relative;">
            <strong style="color:#E63F78;float: left;">觅约待评价&nbsp;&nbsp;&nbsp;<small style="color:#000;">还有<?=count($model)?>人</small></strong>
            <a style="float: right;right:-10px;top:0;margin-right: 20px;width: 40px;height: 40px;background-color:rgba(108, 108, 108, 0.62);border-radius: 50%;font-size: 14px;text-align:center;line-height: 40px;color:#fff;position: absolute;" id="skip_teach" href="http://13loveme.com/w-flop/area?openid=<?=$openid?>">翻牌</a>
        </div>
    </div>
    <div class="row">
        <img style="width: 90%;" class="center-block" src="<?=$model[0]['img']?>">
    </div>
    <div class="row">
        <form action="comments?openid=<?=$openid?>" method="post" name="image" enctype="multipart/form-data">
            <div class="form-group clearfix">
                <div class="col-xs-2">①</div>
                <div class="col-xs-3"><input type="radio" name="dated" value="1" data-labelauty="已约"></div>
                <div class="col-xs-3"><input type="radio" name="dated" value="2" data-labelauty="未约"></div>
            </div>
            <div class="form-group clearfix">
                <div class="col-xs-2">②</div>
                <div class="col-xs-3"><input type="radio" name="evaluate" value="3" data-labelauty="差评"></div>
                <div class="col-xs-3"><input type="radio" name="evaluate" value="2" data-labelauty="一般"></div>
                <div class="col-xs-3"><input type="radio" name="evaluate" value="1" data-labelauty="好评"></div>
            </div>
            <div class="form-group clearfix" style="margin-bottom: 10px;">
                <div class="col-xs-2">③</div><div class="col-xs-10" style="line-height: 35px;">评价内容</div>
            </div>
            <input type="hidden" name="id" value="<?=$model[0]['id']?>">
            <div class="form-group clearfix">
                <div class="col-xs-12" style="padding:0 20px;"><textarea rows="4" maxlength="200" title="comments" class="form-control" name="content"></textarea></div>
            </div>
            <input id="submit" class="btn center-block navbar-fixed-bottom" style="width: 90%;background-color:#272636;color:#fff;font-size: 20px;bottom:5px;" value="提交" type="submit">
        </form>
    </div>
</div>

<script type="text/javascript">
    $(function(){

        $(':input').labelauty();

        $('#submit').on('click',function () {

            var dated= $('input:radio[name="dated"]:checked').val();
            var evaluate= $('input:radio[name="evaluate"]:checked').val();
            if(dated==null || evaluate==null){
                alert('①、②为必选项');
                return false;
            }
        });
    });
</script>
