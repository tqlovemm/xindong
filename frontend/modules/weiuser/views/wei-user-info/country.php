<?php
use common\components\Vip;
    $this->title = "";
    $this->registerCss("
        .weui-cells{font-size:14px;}
    ");
?>

<div class="weui-cells__title">当前位置</div>
<div class="weui-cells">
    <a id="next_url" class="weui-cell" href="">
      <div class="weui-cell__bd">
            <p><img style="width: 18px;float: left;margin-right: 10px;" src="/images/flag.jpg"><span id="location"><i class="weui-loading"></i></span></p>
        </div>
        <div class="weui-cell__ft" style="font-size: 12px;"></div>
    </a>
</div>

<div class="weui-cells__title">全部地区</div>
<div class="weui-cells">
    <a class="weui-cell" href="province?code=<?=$userModel->area->country?>">
      <div class="weui-cell__bd">
            <p>
                <?=Vip::cnArea($userModel->area->country,$userModel->area->province,$userModel->area->city)?>
            </p>
        </div>
        <div class="weui-cell__ft" style="font-size: 12px;">已选地区</div>
    </a>
</div>

<div class="weui-cells">
    <?php foreach ($model as $key=>$list):?>
    <a class="weui-cell weui-cell_access" href="province?code=<?=$key?>">
        <div class="weui-cell__bd">
            <p><?=$list?></p>
        </div>
    </a>
    <?php endforeach;?>
</div>
<script src="http://13loveme.com/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    wx.config({
        debug: false,
        appId: '<?= $signPackage["appId"];?>',
        timestamp: '<?= $signPackage["timestamp"];?>',
        nonceStr: '<?= $signPackage["nonceStr"];?>',
        signature: '<?= $signPackage["signature"];?>',
        jsApiList: ['getLocation'
            // 所有要调用的 API 都要加到这个列表中
        ]
    });

    wx.ready(function () {
        wx.getLocation({
            type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
            success: function (res) {
                var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。

                $.get('get-location?lat='+latitude+'&lon='+longitude,function (data) {
                    var res = $.parseJSON(data);
                    $('#location').html(res.province+' '+res.city);
                    $('#next_url').attr('href',res.code);
                });

 /*
                var speed = res.speed; // 速度，以米/每秒计
                var accuracy = res.accuracy; // 位置精度
                alert(latitude);*/
            }
        });
    });

</script>
