<?php

$this->registerCss("

    .jiecao-serach-box{padding:20px;color:gray;}
    .box1{background-color:rgba(154, 238, 128, 0.54);}
    .box2{background-color:rgba(254, 238, 128, 0.54);}
    .box3{background-color:rgba(254, 138, 128, 0.54);}
    .jiecao-serach-box:hover{box-shadow:0 0 3px red;}

");
?>

<div class="row" style="margin: 0;">
    <a class="col-md-2 col-md-offset-1 text-center jiecao-serach-box box2" href="add">
        <div class="">
            <span style="font-size: 40px;" class="glyphicon glyphicon-plus"></span>
        </div>
        <div class="">增加会员节操币</div>
    </a>
   <a class="col-md-2 col-md-offset-1 text-center jiecao-serach-box box3" href="reduce">
        <div class="">
            <span style="font-size: 40px;" class="glyphicon glyphicon-minus"></span>
        </div>
        <div class="">扣除会员节操币</div>
    </a>


</div>

