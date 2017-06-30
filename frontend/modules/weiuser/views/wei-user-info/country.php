<?php
    $this->title = "";
    $this->registerCss("
    .weui-cells{font-size:14px;}
    
    ");
?>
<div class="weui-cells__title">当前位置</div>
<div class="weui-cells">
    <div class="weui-cell">
      <div class="weui-cell__bd">
            <p><?=\common\components\Vip::locationArea()?></p>
        </div>
        <div class="weui-cell__ft" style="font-size: 12px;"></div>
    </div>
</div>

<div class="weui-cells__title">全部地区</div>
<div class="weui-cells">
    <a class="weui-cell" href="province?code=<?=$userModel->area->country?>">
      <div class="weui-cell__bd">
            <p>
                <?=\common\components\Vip::cnArea($userModel->area->country,$userModel->area->province,$userModel->area->city)?>
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
