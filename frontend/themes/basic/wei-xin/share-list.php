<?php
$this->title = "被分享高端女生的编号";
$this->registerCssFile("@web/css/note/base.css");
$this->registerCssFile("@web/css/note/style.css");
$this->registerCss("
    .navbar,footer,.weibo-share{display:none;}
    .article{margin-bottom:10px;}
    .list-header{position: relative;}
    .list-header a{position: absolute;top:0;color:#EFB810;font-size: 16px;padding:10px 10px 0;}
    .list-header h4{background-color: #1C1B21;padding:10px 0;margin-top: 0;color: #EFB810;font-weight: bold;}
");
?>
<div class="row list-header">
    <h4 class="text-center"><?=$this->title?></h4>
</div>
<div class="row" style="padding-bottom: 60px;">
    <ul class="wall">
        <?php foreach ($query as $item):?>
            <li class="article">
                <h5 style="margin-top: 0;">编号：<?=$item['id']?></h5>
            </li>
        <?php endforeach;?>
    </ul>
</div>
<?php
$this->registerJs("

/*瀑布流*/
$('.wall').jaliswall({ item: '.article' });
       
");

$img = isset($img['img'])?$img['img']:'';
?>
