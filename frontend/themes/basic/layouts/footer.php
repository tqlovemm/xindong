<?php
    $this->registerCss("

     #btoolbar {position: fixed;bottom: 0;width: 100%;height: 45px;z-index: 10;}
    .btool {height: 45px;border-top: #e8e8e8 1px solid;background: #f4f5f6;}
    .cl {zoom: 1;}
    .btoolft li {float: left;width: 20%;padding: 0 0 0 0;text-align: center;color: #666;}
    .btoolft li a {color: #666;display: block; height: 45px;line-height: 12px;font-size: 0.9em;margin-top: 2px;font-weight: 100;}

    .btoolft li a i {line-height: 26px;}
    .btoolft li a span {display: block;}
");
?>
<div id="btoolbar" class="row">
    <div class="btool btoolft cl">
        <ul>
            <li class="c1"><a><i class="glyphicon glyphicon-home"></i><span>首页</span></a></li>
            <li class="c2"><a><i class="glyphicon glyphicon-picture"></i><span>论坛</span></a></li>
            <li class="c3"><a><i class="glyphicon glyphicon-plus"></i><span>发帖</span></a></li>
            <li class="c4"><a><i class="glyphicon glyphicon-heart"></i><span>觅约</span></a></li>
            <li class="c5"><a><i class="glyphicon glyphicon-user"></i><span>我</span></a></li>
        </ul>
    </div>
</div>
