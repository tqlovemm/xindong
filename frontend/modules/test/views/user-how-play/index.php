<?php
$this->title = "高级会员守则";
$this->registerCssFile("@web/css/note/base.css");
$this->registerCssFile("@web/css/note/style.css");
$this->registerCss('
    .container-fluid{padding:0;margin:0;}
    h4{font-weight:bold;padding:20px 0;}
    .mytext{padding-left: 20px;line-height:160%}
    .weixin_number .weixin{text-indent:15px;}
    ul,ul li{list-style-type:none;}
    .myheader{
        font-size:18px;
        font-weight:bold;
        width: 100%;
        background-color: black;
        color: #eee;
        z-index:999;
    }
    .myheader span{text-align:center;}
     @media screen and (max-width: 600px) { /*当屏幕尺寸小于600px时，应用下面的CSS样式*/
        #mytitle{font-size:16px;line-height:160%;text-indent:15px;text-align:left;}
    }
');
$this->registerJs("

    var obj = '.myheader';
    var initPos = $(obj).offset().top;

    var distance = 0;
  	$(window).scroll(function(event) {
        var objTop = $(obj).offset().top - $(window).scrollTop();
        if(objTop<=distance){
            $(obj).css('position','fixed');
            $(obj).css('top',distance+'px');
        }
        if($(obj).offset().top<=initPos){
            $(obj).css('position','static');
        }
    });
");
?>
<div class="myheader">
    <div class="row member-center "style="padding:0 10px;z-index: -1">
        <header>
            <div class="header">
                <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
                <h2 style="margin:0;"><?=$this->title?></h2>
                <a id="list_01" href="/member/setting" class="	glyphicon glyphicon-cog"  style="right:3%;top:0;font-size:20px;line-height: 44px;position: absolute;"></a>
            </div>
        </header>
    </div>
</div>
<div class="center-block">
    <div class="col-md-offset-2 col-md-8 mytext" style="padding:10px;background-color: #fff;border-radius: 5px;s">
        <h4 class="text-center" id="mytitle" style="margin-top: 0;"><?=$model['title']?></h4>
        <div>
            <h4>高级会员玩法：</h4>
            <div class="mytext"><?=$model['instruction']?></div>
        </div>
        <div>
            <h4>会员约会守则：</h4>
            <div class="mytext"><?=$model['rule']?></div>
        </div>
        <h4 style="padding-top:20px; ">需要更多服务、需要了解更多的，欢迎找客服咨询哦~</h4>
        <div>
            <h4>客服在线时间：</h4>
            <div class="mytext">
                <?php $arr0 = explode(';',$model['inline_time']);?>
                <ul>
                <?php foreach($arr0 as $item):?>
                    <li><?=$item?></li>
                <?php endforeach;?>
                </ul>
            </div>
        </div>
        <div class="weixin_number">
            <h4>我们的官方福利微信：</h4>
            <?php $arr1 = explode(';',$model['weibo']); ?>
            <div class="weixin"><?=$arr1[0]?></div>
            <h4>微信公众号：</h4>
            <div class="weixin"><?=$arr1[1]?></div>
            <h4>微信订阅号：</h4>
            <div class="weixin"><?=$arr1[2]?></div>
        </div>
        <div style="padding: 20px 0;"><span style="font-weight: bold">注：</span><?=$model['explain']?></div>
    </div>
</div>
