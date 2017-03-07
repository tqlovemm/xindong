<?php
use yii\widgets\LinkPager;
$this->registerCss('
    footer{display:none;}
    .nav > li > a{padding:8px 12px;}
');
?>

<div class="container">
<div class="row">

    <form class="navbar-form navbar-left clearfix" role="search" style="margin: 0;">
        <div class="form-group" style="width: 70%;float: left;">
            <input type="text" class="form-control" name="number" placeholder="输入编号">
        </div>
        <button type="submit" class="btn btn-default pull-right" style="width: 30%;">搜索</button>
    </form>
</div>
<ul id="myTab" class="nav nav-tabs row">
    <li class="active"><a href="#ejb" data-toggle="tab">待审核</a></li>
    <li><a href="#ios" data-toggle="tab">审核通过</a></li>
    <li><a href="#jmeter" data-toggle="tab">待提交</a></li>
    <li><a href="/collecting-files/send-collecting-url" >生成链接</a></li>
</ul>
<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade in active" id="ejb">
        <div class="row" style="background-color: #fff;padding: 10px;text-align: center;margin-bottom: 5px;">
            <div class="col-xs-6">会员编号</div>
            <div class="col-xs-6">操作</div>
        </div>
        <?php foreach ($model1 as $item): ?>
            <div class="row" style="background-color: #fff;padding: 10px;text-align: center;margin-bottom: 5px;">
                <div class="col-xs-6"><?=$item['id']?></div>
                <a class="col-xs-6" href="/collecting-files/info-detail?id=<?=$item['id']?>">查看</a>
            </div>
        <?php endforeach;?>
        <div class="text-center">
            <?= LinkPager::widget(['pagination' => $pages1]); ?>
        </div>
    </div>
    <div class="tab-pane fade" id="ios">
        <div class="row" style="background-color: #fff;padding: 10px;text-align: center;margin-bottom: 5px;">
            <div class="col-xs-6">会员编号</div>
            <div class="col-xs-6">操作</div>
        </div>
        <?php foreach ($model2 as $item): ?>
            <div class="row" style="background-color: #fff;padding: 10px;text-align: center;margin-bottom: 5px;">
                <div class="col-xs-6"><?=$item['id']?></div>
                <a class="col-xs-6" href="/collecting-files/info-detail?id=<?=$item['id']?>">查看</a>
            </div>
        <?php endforeach;?>
        <div class="text-center">
            <?= LinkPager::widget(['pagination' => $pages2]); ?>
        </div>
    </div>
    <div class="tab-pane fade" id="jmeter">
        <div class="row" style="background-color: #fff;padding: 10px;text-align: center;margin-bottom: 5px;">
            <div class="col-xs-6">会员编号</div>
            <div class="col-xs-6">操作</div>
        </div>
        <?php foreach ($model3 as $item): ?>
            <div class="row" style="background-color: #fff;padding: 10px;text-align: center;margin-bottom: 5px;">
                <div class="col-xs-6"><?=$item['id']?></div>
                <a class="col-xs-6" href="/collecting-files/info-detail?id=<?=$item['id']?>">查看</a>
            </div>
        <?php endforeach;?>
        <div class="text-center">
            <?= LinkPager::widget(['pagination' => $pages3]); ?>
        </div>
    </div>
</div>

</div>