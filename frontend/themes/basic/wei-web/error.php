<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/30
 * Time: 12:45
 */
$this->registerCss("


    header{height:44px;background: #E83F78;position: relative;z-index: 10;margin-bottom:15px;}
    header a{color:white;position: absolute;}
    header h2{color: #fff;font-size: 16px;font-weight: normal;height:44px;text-align: center;line-height:44px;font-weight: bold;margin-top: 0;}
    header span{display: block;height: 35px;text-indent: 17px;width: 50px;color: #FFF;font-size: 14px;padding-top: 8px;margin-left: -10px;}
    header span img{width: 25px;}


");
?>
<header class="row">
    <div class="header">
        <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
        <h2><?=$this->title?></h2>
    </div>
</header>
<div class="text-center">
    <?php if($type==1):?>
        <h3>报名失败-您参与过报名</h3>
    <?php elseif($type==2):?>
        <h3>报名失败-您的会员编号不存在</h3>
    <?php endif;?>
</div>
