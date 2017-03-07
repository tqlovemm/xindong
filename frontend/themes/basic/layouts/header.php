<?php

$this->registerCss("


    header{width:100%;height:44px;background: #4A4A4A;position: relative;z-index: 10;margin-bottom:15px;}
    header a{color:white;position: absolute;}
    header h2{color: #fff;font-size: 16px;font-weight: normal;height:44px;text-align: center;line-height:44px;font-weight: bold;margin-top: 0;}
    header span{display: block;height: 35px;text-indent: 17px;width: 50px;color: #FFF;font-size: 14px;padding-top: 8px;margin-left: -10px;}
    header span img{width: 25px;}
    ul, ol, li {list-style: none;margin: 0;padding: 0;}
    .openr {-webkit-transform: translateX(-150px);-moz-transform: translateX(-150px);-ms-transform: translateX(-150px);transform: translateX(-150px);-webkit-box-shadow: 3px 3px 9px rgba(0,0,0,0.7);box-shadow: 3px 3px 9px rgba(0,0,0,0.7);min-width: 150px;overflow: hidden;}
    .member{position: relative;background: #eee;z-index: 10;-webkit-transition: 0.4s;-moz-transition: 0.4s;-ms-transition: 0.4s;transition: 0.4s;height: 100%;}
    #list_01:visited,#list_01:link,#list_01:hover{color: #fff;}
    .member .row{margin-right: 0;margin-left: 0;}

");

$this->registerJs("

     $('#list_01').on('click',function(){

            $(\".member\").toggleClass(\"openr\");


        });
");

?>
<header>
    <div class="header">
        <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
        <h2><?=$this->title?></h2>
        <a id="list_01" class="glyphicon glyphicon-list"  style="right:3%;top:0;font-size:20px;line-height: 44px;position: absolute;"></a>
    </div>
</header>
