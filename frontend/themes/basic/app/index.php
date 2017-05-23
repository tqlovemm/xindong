<?php
return var_dump(json_encode($model));
$this->registerCss("
    .container-fluid {padding-right: 0;padding-left: 0;}
    .weui_cells {margin-top: 0 !important;}
    p{margin-bottom:0;}
    h4, .h4, h5, .h5, h6, .h6 {margin-top: 0;}
");
?>
<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
<div class="weui_cells">
    <div class="weui_cell">
        <div class="weui_cell_bd weui_cell_primary">
            <p>用户ID</p>
        </div>
        <div class="weui_cell_ft"><?=json_encode($model)?></div>
    </div>
</div>
<div class="weui_panel weui_panel_access">
    <div class="weui_panel_hd">充值信息</div>
    <div class="weui_panel_bd">
        <div class="weui_media_box weui_media_text">
            <h4 class="weui_media_title">金额</h4>
            <p class="weui_media_desc">充值金额：<?=$model->total_fee?>，赠送：<?=$model->giveaway?></p>
        </div>
        <div class="weui_media_box weui_media_text">
            <h4 class="weui_media_title">描述</h4>
            <p class="weui_media_desc"><?=$model->subject?>，<?=$model->description?></p>
        </div>
        <div class="weui_media_box weui_media_text">
            <h4 class="weui_media_title">支付订单号</h4>
            <p class="weui_media_desc"><?=$model->alipay_order?></p>
        </div>
        <div class="weui_media_box weui_media_text">
            <h4 class="weui_media_title">充值时间</h4>
            <p class="weui_media_desc"><?=date('Y-m-d H:i:s',$model->updated_at)?></p>
        </div>
    </div>
</div>