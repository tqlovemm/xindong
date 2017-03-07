<?php
$this->title = mb_substr($model->subject,0,8,'utf8').'..';
$this->registerCss("
body{    font-family: Arial,sans-serif;}
.login-page, .register-page {
    background-color: #F9F9F9;
    
}
.container{padding:0;width:100%;}
.search-box .row{margin:0;}
#p-header {
    position: fixed;
    width: 100%;
    left: 0;
    top: 0;
    min-height: 50px;
    z-index: 100;
    text-align: left;
}
.spect-header {
    position: relative;
    background-color: #37b059;
    height: 42px;
    padding: 8px 100px 0 40px;
}
header {
    display: block!important;
}
.spect-header .cont {
    width: 100%;
    overflow: hidden;
}
.spect-header .home {
    width: 44px;
    height: 50px;
    left: 0;
    top: 0;
}

.spect-header a {
    color: #fff;
}
.pa {
    position: absolute;
}
.spect-header .appendix {
    font-size: 16px;
    line-height: 1;
    color: #fff;
    width: 88px;
    right: 0;
    top: 17px;
}
.spect-header .ask {
    border-right: 1px solid #9bd8ac;
    padding-right: 12px;
}
.dib {
    display: inline-block;
}
.spect-header .home:before {
    background: url(/images/search/OkOfDMYdl83Ebpxj3NPesGzO4linPMTf7dacR3HV3mrhiJVqpyxVQLjHEMrzZjXPgHSL5nPJLOPTaTwxFhWZ7fIXHiXKiMj0k8Li+M88+Rtr5jIJDoMgWOjzLGIWI56Z0oLWc4a+AV5URXtMlhKXAAAAAElFTkSuQmCC.png);
    background-size: 17px 17px;
    width: 17px;
    height: 17px;
    content: '';
    display: block;
    margin: 15px 0 0 10px;
}
.spect-header .option span {
    margin: 17px 0 0 12px;
    background: url(/images/search/49C3mgAAAAEdFJOUwDKy8nlHQGdAAAAG0lEQVQY02NgIBGYuCADRwYRFL4Tw2ADI9y9AKicFxpkJqsHAAAAAElFTkSuQmCC.png);
    width: 15px;
    height: 15px;
    background-size: 15px 15px;
    vertical-align: top;
    -webkit-transition: all .3s;
}
.spect-header .option {
    position: absolute;
    width: 42px;
    height: 50px;
    right: 0;
    top: -17px;
    z-index: 60;
}
.w-question-box h2{
    color: #333;
    font-size: 18px;
    line-height: 24px;
    display: inline;
    margin-right: 9px;
    font-weight:bold;
}


.w-answer {
    padding: 10px 10px 10px 0;
}
.w-answer>a {
    display: block;
    width: 92px;
    line-height: 24px;
    text-align: center;
    border: 1px solid #ccc;
    color: #666;
}
.mm-submit-button {
    border: 1px solid #37B059;
    border-radius: 12px;
    font-size: 14px;
    color: #37B059;
    min-width: 64px;
    height: 24px;
    background-color: #fff;
}
.w-answer .answer-area {
    margin-top: 10px;
}
.w-answer .d-arr {
    width: 8px;
    height: 8px;
    margin-left: 7px;
    position: relative;
    top: -3px;
}
.w-answer .up {
    top: 2px;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
}
.d-arr {
    -webkit-transform: rotate(135deg);
    -webkit-transition: all .3s;
}
.r-arr, .d-arr {
    display: inline-block;
    width: 6px;
    height: 6px;
    border-top: 1px solid #9d9d9d;
    border-right: 1px solid #9d9d9d;
    margin-left: 2px;
}
.mm-input-box {
    border: 1px solid #e5e5e5;

    border-radius: 2px;
    padding: 10px;
    background: #fff;
    margin-bottom: 5px;
}
input, textarea {
    -webkit-tap-highlight-color: rgba(255,0,0,0);
}

input, textarea {
    outline: 0;
    -webkit-appearance: none;
    padding: 0;
    margin: 0;
}
.mm-input-box textarea {
    border: 0;
    display: block;
    width: 100%;
    padding: 0;
    font-size: 14px;
}
.w-reply .append {
    margin-top: 7px;
    min-height: 21px;
    line-height: 21px;
}
.replier-info {
    font-size: 14px;
    position: relative;
    color: #9d9d9d;
    padding: 3px 0 3px 30px;
    line-height: 1;
}
.usr-action {
    color: #9d9d9d;
    text-align: center;

}
.replier-info .u-ico {
    position: absolute;
    background-repeat: no-repeat;
    background-position: 50% 50%;
    background-size: contain;
    border-radius: 50%;
    left: 0;
    top: 0;
    width: 20px;
    height: 20px;
}
.replier-info span {
    display: inline-block;
}
.replier-info {
    font-size: 14px;
    position: relative;
    color: #9d9d9d;
    padding: 3px 0 3px 30px;
    line-height: 1;
}
.replier-info .date {
    margin-left: 8px;
    margin-right: 8px;
    padding-left: 8px;
    padding-right: 8px;
    border-left: 1px solid #e5e5e5;
    border-right: 1px solid #e5e5e5;
    color: #9d9d9d;
}
.usr-action>div {
    width: 33.33%;
    float: left;
    position: relative;
    height: 20px;
    line-height: 20px;
    font-size: 14px;
}
.w-support {
    position: relative;
    display: -webkit-box;
    -webkit-box-orient: horizontal;
}
.w-support .em {
    text-align: right;
}
.w-support .em, .w-support b {
    display: block;
    width: 50%;
}
.w-support b {
    text-align: left;
}

.w-support .em, .w-support b {
    display: block;
    width: 50%;
}
.usr-action b {
    font-weight: 400;
}
.spect-header .msg-list {
    position: absolute;
    z-index: 10;
    top: 50px;
    right: 5px;
    width: 132px;
    background-color: #fff;
    border: 1px solid #f6f6f6;
    border-radius: 4px;
    box-shadow: 1px 0 3px #e9e9e9;
    display: none;
    opacity: 0;
}
.spect-header .msg-list a {
    position: relative;
    height: 37px;
    line-height: 37px;
    color: #666;
    font-size: 15px;
    margin: 0 6px;
    border-bottom: 1px solid #ededed;
    padding-left: 36px;
    display: block;
}
.spect-header .msg-list .ico-ask {
    background-position: 0 0;
}
.spect-header .msg-list .ico {
    position: absolute;
    width: 15px;
    height: 15px;
    top: 11px;
    left: 13px;
}
.spect-header .toggle {
    -webkit-transform: rotate(90deg);
}

");

?>
<div id="p-header">
    <header class="spect-header">
        <div class="cont">
            <a class="home pa" href="http://13loveme.com:82/search/search.php"></a>
            <div class="text-center" style="line-height:32px;color: #fff;"><?=$this->title?></div>
            <div class="appendix pa">
                <span class="ask dib"><a class="go-to-ask" href="put-questions">提问</a></span><span class="option dib"><span class="dib"></span></span>
            </div>
            <div class="msg-list msg-list-active" style="display: none;opacity: 1 !important;">
                <a href="your-questions"><span class="ico ico-ask"></span>我的提问</a>
                <a href="your-questions?type=3"><span class="ico ico-ask"></span>他人提问</a>
                <a href="your-questions?type=2"><span class="ico ico-ans"></span>我的回答</a>
                <span class="ar"></span>
            </div>
            <span class="back-arr hide"></span>
        </div>
    </header>
</div>

<div class="search-box" style="padding:10px;background-color: #fff;margin-top: 40px;">
    <div class="row w-question-box">
        <?php if(!empty($model)):?>
            <h2><?=\yii\helpers\Html::encode($model->subject)?></h2>
            <div class="w-answer clearfix" id="w-1">
                <a href="javascript:void(0)" class="mm-submit-button goanswer">我来解答<span class="d-arr"></span></a>
                <div class="answer-area" style="display: none;">
                    <form action="answer-create" method="post" class="clear" onsubmit="return validate_form(this)" >
                        <div class="mm-input-box">
                            <textarea style="height: 90px;" name="search_content" placeholder="请输入您的回答..."></textarea>
                        </div>
                        <input type="hidden" name="pid" value="<?=$model->pid?>">
                        <input class="mm-submit-button submitBtn pull-right" type="submit" value="提交">
                    </form>
                </div>
            </div>
            <p style="font-size: 15px;">
                <?=\yii\helpers\Html::encode($model->message)?>
            </p>
        <?php endif;?>
    </div>
    <div class="row">
    <?php if(!empty($images)):
        foreach ($images as $key=>$image):?>
            <a href="<?=$image->pic_path?>" class="col-md-2" style="<?php if($key==0){echo 'padding-left:0;';}?>">
                <img class="img-responsive" src="<?=$image->pic_path?>">
            </a>
    <?php endforeach;endif;?>
    </div>
    <div class="row append">
        <div class="replier-info">
            <span class="u-ico" style="background-image:url(<?='/images/avatar/default/'.rand(1,40).'.jpg'?>)"></span><span class="name"><?=$model->created_by?></span>
            <span class="date"><?=date('Y-m-d',$model->chrono)?></span>
            <span class="usr-action cf" onclick="thumbs_up(<?=$model->pid?>,1,this)">
                    <span class="glyphicon glyphicon-thumbs-up"></span> <b><?=$model->thumbs_up?></b>
                </span>
        </div>
    </div>
    <hr>
    <h4>其他回答或评论</h4>

    <?php foreach ($addAnswer as $list):?>
    <div class="row">
        <p style="font-size: 15px;"><?=\yii\helpers\Html::encode($list['content'])?></p>
    </div>
    <div class="row">
        <div class="append">
            <div class="replier-info">
                <span class="u-ico" style="background-image:url(<?='/images/avatar/default/'.rand(1,40).'.jpg'?>)"></span><span class="name"><?=$list['created_by']?></span>
                <span class="date"><?=date('Y-m-d',$list['created_at'])?></span>
                <span class="usr-action cf" onclick="thumbs_up(<?=$list['id']?>,2,this)">
                    <span class="glyphicon glyphicon-thumbs-up"></span> <b><?=$list['thumbs_up']?></b>
                </span>
            </div>
        </div>
    </div><hr>
    <?php endforeach;?>
</div>
<?php $this->registerJs("

   $('.mm-submit-button').click(function(){
   
        if($('.d-arr').hasClass('up')){
            $('.d-arr').removeClass('up');
            $('.answer-area').hide();
        }else{
            $('.d-arr').addClass('up');
            $('.answer-area').show();
        }
        
   });   
   
   $('.option').click(function(){
   
        if($('.spect-header .option span').hasClass('toggle')){
            $('.spect-header .option span').removeClass('toggle');
            $('.msg-list-active').hide();
        }else{
            $('.spect-header .option span').addClass('toggle');
            $('.msg-list-active').show();
        }
        
   });

");?>
<script>

    function validate_required(field,alerttxt)
    {
        with (field)
        {
            if (value==null||value=="")
            {alert(alerttxt);return false}
            else {return true}
        }
    }

    function validate_form(thisform)
    {
        with (thisform)
        {
            if (validate_required(search_content,"回答不可为空")==false)
            {search_content.focus();return false}
        }
    }

    function thumbs_up(pid,type,con) {

        var cox = $(con);
        var b = cox.children('b');
        $.get('thumbs-up?pid='+pid+'&type='+type,function (data) {
            if(data==0){
                alert('你已经点赞');return;
            }
            b.html(data);
        })
    }

</script>
