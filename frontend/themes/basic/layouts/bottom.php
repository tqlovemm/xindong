<?php
    $this->registerCss("

        .bottom-bar{font-size: 15px;padding:10px;background-color: rgba(50, 50, 50, 0.9);}
        .bottom-bar a{color:#fff;}
        .border-right{border-right: 1px solid #8b8b8b;}

    ");
?>
<!--不要提交-->
<?php if(!Yii::$app->user->isGuest):?>
<div class="row navbar-fixed-bottom bottom-bar text-center visible-sm visible-xs">
    <a href="/date-today" class="col-xs-6 border-right">
        <span class="glyphicon glyphicon-heart"></span>
        <span> 最新密约</span>
    </a>
    <a href="/member/user" class="col-xs-6">
        <span class="glyphicon glyphicon-user"></span>
        <span> 个人中心</span>
    </a>
</div>
<?php endif;?>