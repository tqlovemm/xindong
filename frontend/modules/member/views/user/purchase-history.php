<?php
$this->title = "寻约记录";

$this->registerCss("

    .purchase-history{padding:0 10px;margin-bottom:15px;margin-left:0;margin-right:0;}
    .purchase-history-box{background-color:#fff;padding:10px;box-shadow: 0 0 3px #D5D3D3;border-radius:5px;font-size:12px;}
    .purchase-history-box hr{margin:15px 0;}
    .purchase-history-box p{font-size: 12px;}

");

?>
    <div class="row member-center">
        <header>
            <div class="header">
                <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
                <h2 style="margin:0;"><?=$this->title?></h2>
            </div>
        </header>
    </div>
<?php foreach($model as $item):?>

    <?php if($item['subject']==2){

        $notice_title = "觅约报名通知";
        $notice_content = "恭喜您$item[type]成功";
        $pay = $item['number'].'节币';
    }
    ?>

    <div class="row purchase-history">
        <div class="purchase-history-box">
            <h5 style="font-weight: bold;"><?=$notice_title?></h5>
            <h6><?=date("Y-m-d H:i:s",$item['created_at'])?></h6>
            <h6 class="text-center">消费金额:</h6>
            <h1 class="text-center" style="margin-top: 0;"><?=$pay?></h1>
            <hr style="border-top: 1px dashed #D0D0D0;">
            <h5>支付类型：<?=$item['type']?></h5>
            <h5>订单号：<?=$item['order_number']?></h5>
            <p><?=$notice_content?></p>
            <p><?=var_dump(json_decode($item['extra'],true))?></p>
        </div>
    </div>
<?php endforeach;?>