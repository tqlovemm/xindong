<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
<div class="weui_msg">
    <div class="weui_icon_area"><i class="weui_icon_success weui_icon_msg"></i></div>
    <div class="weui_text_area">
        <h2 class="weui_msg_title">报名成功</h2>
        <p class="weui_msg_desc">您的参赛报名已经成功，请耐心等待管理员的审核</p>
    </div>
    <div class="weui_opr_area">
        <p class="weui_btn_area">
            <a href="center?Id=<?=Yii::$app->session->get('Id')?>" class="weui_btn weui_btn_primary">确定</a>
        </p>
    </div>
    <div class="weui_extra_area">
        <a href="join-info?Id=<?=Yii::$app->session->get('Id')?>">查看详情</a>
    </div>
</div>