<?php
$number = \backend\models\User::getNumber($model['user_id']);
$vip = $model['pre_vip'];
if($vip==2){$vip="普通会员";}elseif($vip==3){$vip="高端会员";}elseif($vip==4){$vip="至尊会员";}elseif($vip==5){$vip="私人定制";}else{$vip="不知会员等级";}
$nickname = \backend\models\User::findOne($model['created_by'])->nickname;
if($model['status']==1){
    $check = "未审核";
    $checker = "审核人：还未审核";
}elseif($model['status']==2){
    $check = "审核通过";
    $checker = "审核人：".\backend\models\User::findOne($model['checker'])->nickname.'&nbsp;&nbsp;&nbsp;审核时间：'.date('Y-m-d H:i:s',$model['updated_at']);
}else{
    $check = "审核不通过";
    $checker = "审核人：".\backend\models\User::findOne($model['checker'])->nickname.'&nbsp;&nbsp;&nbsp;审核时间：'.date('Y-m-d H:i:s',$model['updated_at']);
}
if($model['type']==1){
    $this->title = "添加会员节操币通知";
    $notice = "管理员：{$nickname}，给会员编号：{$number}，添加节操币：{$model['coin']},该会员现在等级：{$vip}，当前已经拥有节操币：{$model['pre_coin']}";
}elseif($model['type']==2){
    $this->title = "升级会员通知";
    $vip_to = $model['vip'];
    if($vip_to==2){$vip_to="普通会员";}elseif($vip_to==3){$vip_to="高端会员";}elseif($vip_to==4){$vip_to="至尊会员";}elseif($vip_to==5){$vip_to="私人定制";}else{$vip_to="不知会员等级";}
    $notice = "管理员：{$nickname}，给会员编号：{$number}升级,该会员由{$vip}升级到{$vip_to}";
}else{}
$this->registerCss("
    .weui_media_box .weui_media_desc{line-height: 25px !important;}
    .weui_media_box .weui_media_desc{-webkit-line-clamp: 4 !important;}
");
?>
<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
<div class="weui_panel row" style="margin-top: 0;">
    <div class="weui_panel_hd"><?=$checker?></div>
    <div class="weui_panel_bd">
        <div class="weui_media_box weui_media_text">
            <h4 class="weui_media_title"><?=$this->title?></h4>
            <p class="weui_media_desc">
                <?=$notice?>
            </p>
            <ul class="weui_media_info">
                <li class="weui_media_info_meta"><?=$number?></li>
                <li class="weui_media_info_meta"><?=date('Y-m-d H:i:s',$model['created_at'])?></li>
                <li class="weui_media_info_meta weui_media_info_meta_extra"><?=$check?></li>
            </ul>
        </div>
    </div>
</div>
<?php if($model['status']==1):?>
<div class="weui_msg">
    <div class="weui_opr_area">
        <p class="weui_btn_area">
            <a href="<?=\yii\helpers\Url::to(['pass-or-no','id'=>$model['id'],'status'=>2,'type'=>$model['type']])?>" class="weui_btn weui_btn_primary" data-confirm="确定同意吗？">同意</a>
            <a href="<?=\yii\helpers\Url::to(['pass-or-no','id'=>$model['id'],'status'=>3,'type'=>$model['type']])?>" class="weui_btn weui_btn_default" data-confirm="确定拒绝吗？">拒绝</a>
        </p>
    </div>
</div>
<?php elseif($model['status']==2):?>
<div class="weui_msg" style="position: absolute;top:-36px;right: 0;">
    <div class="weui_icon_area">
        <i class="weui_icon_success_circle weui_icon_msg"></i>
    </div>
</div>
<?php else:?>
<div class="weui_msg" style="position: absolute;top:-36px;right: 0;">
    <div class="weui_icon_area">
        <i class="weui_icon_cancel weui_icon_msg"></i>
    </div>
</div>
<?php endif;?>
