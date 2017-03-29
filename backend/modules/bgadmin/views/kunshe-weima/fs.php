<?php
use yii\widgets\LinkPager;
$this->title = "渠道粉丝数据统计";
$this->registerCss("
    .table{width:100%;}
    .table thead tr{background-color: #ddd;}
    .table thead tr th{border:1px solid #eee;text-align:center;}
    .table tr td{border:1px solid #eee;text-align:center;}
    .follow{margin-bottom:0;}
    .follow li{list-style: none;}
    .skin-blue-light .main-header .logo{display:none;}
    
    .weimenubox li.on, .weimenubox li.on a {
    background: #d7d7d7;
    color: #333;
    display: block;
}
.weimenubox li {
    float: left;
    height: 30px;
    line-height: 30px;
    border-top: 1px #c9cace solid;
    border-bottom: 1px #c9cace solid;
    border-right: 1px #c9cace solid;
    font-size: 14px;
}
.weimenubox li a {
    padding: 0 25px;
    line-height: 30px;
    height: 30px;
    color: #333;
    text-decoration: none;
    display: block;
}
    .weimenubox {
    margin-bottom: 10px;
    border-left: 1px #c9cace solid;
    
}

.cen {
    width: 100%;
    margin-bottom: 10px;
    margin: 0 auto;
}
.uboxlist {
    border-top: 1px #DDD solid;
    border-left: 1px #DDD solid;
    font-size: 13px;
    text-align: left;
}
.uboxlist li {
    float: left;
    width: 50%;
}
.iubox {
background-color:#fff;
    border-right: 1px #ddd solid;
    border-bottom: 1px #DDD solid;
    padding: 5px 10px;
    overflow: hidden;
}
.iubox_img {
    float: left;
}
.iubox_img img {
    max-height: 46px;
    max-width: 46px;
    overflow: hidden;
}
.iubox_dz {
    float: left;
    padding-left: 10px;
    line-height: 24px;
    max-width: 190px;
    overflow: hidden;
}
.iubox_dz span {
    color: #666;
    font-size: 10px;
}
.iubox_time {
    float: right;
    color: #666;
    font-size: 10px;
}
ul, ol, dl, dt, dd, li {
    list-style: none;
    overflow: hidden;
}
");
$sence_id= Yii::$app->request->get('sence_id');
?>
<div style="width:740px;margin:0 auto;height:40px;line-height:40px;text-align:center;">
    <div class="weimenubox">
        <ul class="list-group">
            <li><a href="<?=\yii\helpers\Url::to(['tong-ji','sence_id'=>$sence_id])?>">渠道粉丝数据统计</a></li>
            <li class="on"><a href="<?=\yii\helpers\Url::to(['fen-si','sence_id'=>$sence_id])?>">渠道粉丝明细</a></li>
            <div class="clearfix"></div>
        </ul>
    </div>
</div>
<table class="table table-bordered" style="margin-bottom: 0;">
    <caption><?=$channel_weima->customer_service?>：渠道二维码粉丝详情</caption>
</table>
<div style="width:100%;margin:0 auto;text-align:center;border:1px #DDD solid;background-color: #ddd;padding: 8px;">总计<?=$pages->totalCount?>人</div>
<div class="cen">
    <div id="dolinglist" style="font-size:14px;text-align:center;">
        <ul class="uboxlist list-group" id="u_list">
            <?php foreach($model as $key=>$item):?>
                <li>
                    <div class="iubox">
                        <div class="iubox_img">
                            <img src="<?=$item['headimgurl']?>"></div>
                        <div class="iubox_dz"><?=$item['nickname']?> <br><span><?=$item['country']?>  <?=$item['province']?>  <?=$item['city']?>  </span></div>
                        <div class="iubox_time"><?=date('Y/m/d H:i:s',$item['subscribe_time'])?></div>
                        <div class="clearfix"></div>
                    </div>
                </li>
            <?php endforeach;?>
            <div class="clearfix"></div>
        </ul>
            <div id="u_list2" style="padding:5px 0;">
                <div class="pagebut" style="width:100%;"></div>
            </div>
    </div>
</div>
<?= LinkPager::widget(['pagination' => $pages]); ?>