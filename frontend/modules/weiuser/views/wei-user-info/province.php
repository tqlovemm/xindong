<?php
$this->title = "";
$this->registerCss("
    .weui-cells{font-size:14px;}
    
    ");
?>
<div class="weui-cells">
    <?php foreach ($model as $key=>$list):?>
    <a class="weui-cell weui-cell_access" href="province?code=<?=$key?>">
        <div class="weui-cell__bd">
            <p><?=$list?></p>
        </div>
     <!--   <div class="weui-cell__ft">
        </div>-->
    </a>
    <?php endforeach;?>
</div>
