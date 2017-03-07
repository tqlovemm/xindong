<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
<div class="weui_msg" style="padding-top: 0;">
    <div class="weui_opr_area">
        <div class="row text-left" style="background-color: #fff;padding:10px;">
            <div class="col-xs-3" style="padding: 0;">
                <img class="img-responsive" style="border-radius: 5px;" src="<?php echo $model->headimgurl?>">
            </div>
            <div class="col-xs-9">
                <h5>认证微信昵称：<?php echo $model->nickname?></h5>
                <h5>认证平台编号：<?php echo $model->number?></h5>
                <h5>认证档案地址：<?php echo $model->address?></h5>
            </div>
        </div>
    </div>
    <div class="weui_text_area" style="margin: 0 -15px;">
        <h2 class="weui_msg_title"><?=$title?></h2>
        <p class="weui_msg_desc">您在平台觅约成功后，平台将会通过微信公众号：心动三十一天 将女生信息联系方式推送给您。<span style="color:#7890ff;">如果您未关注微信公众号，请扫描下面二维码进行关注，否则我们将无法推送给您</span></p>
        <figure>
            <img class="img-responsive center-block" src="/images/weixin/thirteenpingtai.jpg">
        </figure>
    </div>

   <div class="weui_extra_area">
        <a href="">如有疑问可联系十三平台客服咨询</a>
    </div>
</div>
