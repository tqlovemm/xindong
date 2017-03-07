<?php
$this->title = "我的提问";
/*echo '<pre>';
return var_dump($model);*/
$this->registerCss("
    body{ font-family: Arial,sans-serif;}
    .login-page, .register-page {background-color: #eee;}
    .container{width:100%;padding:0;}
  .member-center header{height:40px !important;background-color: #37b059;padding:0 10px;}
    .member-center header h4{text-align:center;line-height:40px;}
    .member-center header a,.member-center header h5{color: #eee !important;line-height:40px;padding:0 10px;}


");
?>
<div class="row member-center">
    <header>
        <div class="header" style="background-color: #37b059;color: #eee;position: relative;">
            <a style="position: absolute;top:0;left:3%;" href="javascript:history.back();">取消</a>
            <h4 style="margin:0;text-align: center;color:#fff;"><?=$this->title?></h4>
            <a href="http://13loveme.com:82/search/search.php" style="position: absolute;right:3%;top:0;">搜索</a>
        </div>
    </header>
</div>
<ul class="list-group">
<?php foreach ($model as $key=>$list):?>
    <li class="list-group-item">
        <a href="search-view?pid=<?=$list['pid']?>" style="color: gray;">
            <p>
                <span style="background-color: #37b059;color:#fff;padding:2px 5px;border-radius: 3px;"><?=$key+1?></span> <?=$list['subject']?>
            </p>
            <hr style="margin: 10px 0;">
            <div class="row list-inline" style="padding: 0;margin: 0;">
                <span>时间：<?=date('Y-m-d',$list['chrono'])?></span>  &nbsp;&nbsp;&nbsp;l  &nbsp;&nbsp;&nbsp;<span>回答数：<?=count($list['addAnswer'])?></span>
            </div>
        </a>
    </li>
<?php endforeach;?>
</ul>