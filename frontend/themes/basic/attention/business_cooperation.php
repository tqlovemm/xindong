
<?php

$this->title='商务合作';

$this->registerCss('

        .attention>li{line-height:25px;margin:10px 0;}

    ');
?>
<div class="container">

    <div class="row">

        <div class="col-md-2">
            <?= $this->render('./attention-left')?>
        </div>
        <div class="col-md-9" style="min-height: 500px;">
            <h1 class="text-center"><?=\yii\helpers\Html::encode($this->title)?></h1>
            <h4><span class="glyphicon glyphicon-hand-right"></span>&nbsp;&nbsp;推广合作</h4>
            <p>品牌及联盟广告投放:欢迎各品牌网站代理及网络联盟恰谈广告推广合作。</p>
            <div class="text-danger"> 联系人：吴先生</div>
            <div class="text-warning">联系邮箱：8495167@qq.com</div>
        </div>
    </div>
</div>