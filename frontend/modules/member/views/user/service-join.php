<?php
    $vip = Yii::$app->user->identity->groupid;
    $coin = ($vip==3)?99:198;
    $e = 0;
    if(!empty($query)){
        $mouth_second = strtotime("+1 months",$query['created_at']);
        $expire_second = $mouth_second-time();

        if($expire_second>0){
            $e = 1;
            $datingVip = "<span style='color: #0c8dff;'>您已经开通客服介入功能</span>";
            $expire_time = "到期时间:".date('Y-m-d',$mouth_second);
        }else{
            $datingVip = "<span style='color: #ffb318;'>您的客服介入功能已过期</span>";
            $expire_time = "到期时间:".date('Y-m-d',$mouth_second);
        }
    }else{

        $datingVip = "<span style='color: #ff705c;'>您尚未开通的客服介入功能</span>";
        $expire_time = "可点击下方开通按钮开通";
    }

?>
<div class="row member-center">
    <header>
        <div class="header">
            <a href="javascript:history.back();"><span><img
                        src="<?= Yii::getAlias('@web') ?>/images/iconfont-fanhui.png"></span></a>
            <h2 style="margin:0;"><?= $this->title ?></h2>
        </div>
    </header>
</div>
<div class="row" style="background-color: #fff;margin-bottom: 10px;padding: 10px;">
    <div class="col-xs-3" style="padding: 0;">
        <img style="border: 1px solid #eee;" class="img-circle img-responsive" src="<?=Yii::$app->user->identity->avatar?>">
    </div>
    <div class="col-xs-9">
        <h4 style="margin: 5px 0;color:gray;"><?=Yii::$app->user->identity->nickname?></h4>
        <h5 style="margin: 10px 0;"><?=$datingVip?></h5>
        <h5 style="color:#aaa;margin: 5px 0;"><?=$expire_time?></h5>
    </div>
</div>
<div class="row">
    <ul class="list-group">
        <li class="list-group-item" style="background-color: #eee;">开通客服介入享如下功能：</li>
        <li class="list-group-item">1：如果您的密约报名长时间没有得到处理，您可以催促客服加快处理进度。</li>
        <li class="list-group-item">2：如果您得到了女生的二维码，但是女生没有同意添加您为好友，您可以要求我们客服介入帮您和女生进行交涉。</li>
    </ul>
    <?php if($e == 0):?><button data-toggle="modal" data-target="#myModal" class="btn btn-success center-block" style="width: 90%;">开通客服介入</button><?php endif;?>
</div>
<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    是否开通会员介入
                </h4>
            </div>
            <div class="modal-body text-center">
                <h5>开通此功能提高女生加好友成功率</h5>
                <br>
                <img class="center-block" style="width: 90px;" src="/images/launch.png">
                <br>
                <p>所需节操币：<?=$coin?>/月</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                </button>
                <button type="button" class="btn btn-primary" onclick="kefujieru()">
                    开通
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script>
    function kefujieru() {
        window.location.href = "dating-vip";
    }
</script>