<?php

$this->registerCss("

    .side_nv {
    width: 150px;
    height: 100%;
    position: absolute;
    right: 0px;
    top: 0px;
    color: #fff;
    background: #000;
    overflow: hidden;
}

.oy .nv, .oy .usli {
    overflow-y: hidden;
    overflow-x: hidden;
}

.nv {
    display: block;
    width: 260px;
    height: 100%;
    background: #4A4A4A;
}
.nv ul {
    width: 260px;
    height: 100%;
}
ul, ol, li {
    list-style: none;
}
ul li, .xl li {
    list-style: none;
}
.nv a {
    display: block;
    height: 50px;
    padding: 0px 0px 0px 30px;
    line-height: 50px;
    font-size: 16px;
    color: #eee;
    overflow: hidden;
    position: relative;
}
.nv a:visited {
    color: #dcdcdc;
}

");

?>

<div id="side_nv" class="side_nv oy">
    <div class="nv">
        <ul>
            <li><a><i class="glyphicon glyphicon-home"></i><span> 首页</span></a></li>
            <li><a><i class="glyphicon glyphicon-heart"></i><span> 觅约</span></a></li>
            <li><a><i class="glyphicon glyphicon-file"></i><span> 论坛</span></a></li>
            <li><a><i class="glyphicon glyphicon-gift"></i><span> 周刊</span></a></li>
            <li><a><i class="glyphicon glyphicon-picture"></i><span> 翻牌</span></a></li>
        </ul>
    </div>
</div>
