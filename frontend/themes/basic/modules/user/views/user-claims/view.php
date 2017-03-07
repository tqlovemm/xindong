<?php
$this->registerCss('
        html,body{overflow:hidden;}
        .navbar-default,.navbar-header,footer{display:none;}
        .content-warning img{width:100px;float:left;}
    ');
if(Yii::$app->session->hasFlash('success')){

    Yii::$app->session->getFlash('success');

}?>
<a class="btn btn-warning pull-right" href="javascript:window.opener=null;window.open('','_self');window.close();">关闭页面</a>

