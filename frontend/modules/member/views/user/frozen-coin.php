<?php
$this->title = "冻结详情";
$this->registerCss("

    .padding0{padding:0;}
");
?>
<div class="row member-center">
    <header>
        <div class="header">
            <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
            <h2 style="margin:0;"><?=$this->title?></h2>
            <a id="list_01" href="/member/setting" class="glyphicon glyphicon-cog"  style="right:3%;top:0;font-size:20px;line-height: 44px;position: absolute;"></a>
        </div>
    </header>
</div>
<?php foreach ($frozen_coin as $item):?>
    <div class="row" style="background-color: #fff;padding:10px 10px 3px;font-size: 12px;">
        <div class="col-xs-4 padding0">冻结：<?=$item['value']?></div>
        <div class="col-xs-8 padding0">信息编号：<?=$item['number_info']?></div>
    </div>
    <hr style="margin: 0;border:none;">
    <div class="row" style="background-color: #fff;padding:3px 10px;font-size: 12px;">
        <div class="col-xs-12 padding0">原因：<?=$item['reason']?></div>
    </div>
    <hr style="margin: 0;border:none;">
    <div class="row" style="background-color: #fff;padding:3px 10px;font-size: 12px;">
        <div class="col-xs-12 padding0">地区：<?=$item['where']?></div>
    </div>
    <hr style="margin: 0;border:none;">
    <div class="row" style="background-color: #fff;padding:3px 10px 10px;margin-bottom: 10px;font-size: 12px;">
        <div class="col-xs-12 padding0">时间：<?=date('Y年m月d日 H:i:s',$item['created_at'])?></div>
    </div>
<?php endforeach;?>
