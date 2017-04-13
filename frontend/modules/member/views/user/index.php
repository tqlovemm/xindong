<?php
use yii\helpers\HtmlPurifier;

$this->title = '会员中心';
$this->registerCss("
    .member-avatar,.member-nickname{padding:10px 15px;overflow: hidden;background-color:white;}
    .member-avatar{height:80px;}
    .member-avatar .col-xs-3{width:60px;}
    .col-xs-7,.col-xs-3,.col-xs-1,.col-xs-5{height:100%;}
    .col-xs-3{padding-left: 0;padding-right:0;line-height: 30px;text-align: left;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;}
    .member-avatar .col-xs-3 img{height:60px;width:100%;}
    .member-nickname{height:50px;margin-top:15px;}
    .member-nickname .col-xs-1{line-height: 30px;font-size: 16px;padding:0;}
    .member-nickname .col-xs-1 .glyphicon-credit-card{color:#40A1FB;}
    .member-nickname .col-xs-1 .glyphicon-picture{color:#FBBC40;}
    .member-nickname .col-xs-1 .glyphicon-tower{color:#D04D9A;}
    .member-nickname .col-xs-1 .glyphicon-cloud-upload{color:#FBBC40;}
    .member-nickname .col-xs-1 .glyphicon-phone{color:#E94A16;}
    .member-nickname .col-xs-5{line-height: 25px;font-size: 14px;}

            /*phone*/

    .avatar{padding:10px;background: #23212E;color:#fff;}
    .member-info{font-size:12px;background:#fff;}
    .member-info .info-box{padding: 15px 15px 10px ;}
    .member-info .info-box .icon-bar{text-align: center;font-size: 25px;margin-bottom: 10px;}
    .info-content {color:gray;}
    .box1{border-bottom: 1px #E6E6E6 solid;border-right: 1px #E6E6E6 solid;}
    .box1 .icon-bar{color: orange;}
    .box2 .icon-bar{color: #EB4F38;}
    .box3 .icon-bar{color: orange;}
    .box4 .icon-bar{color: #ED9233;}

    .box2{border-bottom: 1px #E6E6E6 solid;}
    .box3{border-right: 1px #E6E6E6 solid;}

    .member-list{font-size:12px;background:#fff;padding:10px 0 10px;border-bottom:1px solid #eee;}

    .function-list{padding-bottom:80px;margin-top:10px;}

    ");
?>

    <div class="row member-center">
        <header>
            <div class="header">
                <a href="javascript:history.back();"><span><img
                            src="<?= Yii::getAlias('@web') ?>/images/iconfont-fanhui.png"></span></a>
                <h2 style="margin:0;"><?= $this->title ?></h2>
                <a id="list_01" href="setting" class="glyphicon glyphicon-cog"
                   style="right:3%;top:0;font-size:20px;line-height: 44px;position: absolute;"></a>
            </div>
        </header>
    </div>

    <div class="row avatar text-center">
        <img class="img-responsive center-block img-circle"
             style="width: 80px;border-left:1px solid orange;border-bottom:1px solid orange;border-top:1px solid #18b4ff;border-right:1px solid #18b4ff;"
             src="<?= $model['avatar'] ?>">
        <h6>觅爱号：<?= HtmlPurifier::process($model['username']) ?></h6>
        <h5><?= HtmlPurifier::process($model['nickname']) ?></h5>
    </div>
    <div class="row member-info">
        <div class="col-sm-6 col-xs-6 info-box box1">
            <a href="user/jiecao-coin">
                <div class="icon-bar">
                    <img style="width: 40px;" class="img-responsive center-block"
                         src="<?= Yii::getAlias("@web") ?>/images/member/wallet.png">
                </div>
                <div class="info-content clearfix">
                    <span class="pull-left">节操币</span>
                    <span class="pull-right"><?= $userData['jiecao_coin'] ?></span>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xs-6 info-box box2">
            <a id="credit-intro"> <!--href="user/credit-intro"-->
                <div class="icon-bar">
                    <img style="width: 40px;" class="img-responsive center-block"
                         src="<?= Yii::getAlias("@web") ?>/images/member/bluearrow.png">
                </div>
                <div class="info-content clearfix">
                    <span class="pull-left">魅力值</span>
                    <span class="pull-right"><?= $num['credit'] ?></span>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xs-6 info-box box3">
            <a href="user-show/member-show">
                <div class="icon-bar">
                    <img style="width: 40px;" class="img-responsive center-block"
                         src="<?= Yii::getAlias("@web") ?>/images/member/gaoduan.png">
                </div>
                <div class="info-content clearfix">
                    <span class="pull-left">会员等级</span>
                    <span class="pull-right"><?= $member_type ?></span>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xs-6 info-box box4">
            <a href="user/dating-signup-record">
                <div class="icon-bar">
                    <img style="width: 40px;" class="img-responsive center-block"
                         src="<?= Yii::getAlias("@web") ?>/images/member/redheart.png">
                </div>
                <div class="info-content clearfix">
                    <span class="pull-left">约会记录</span>
                    <span class="pull-right badge"
                          style="background-color: red;"><?php if ($num['dating'] != 0 || $num['firefighter'] != 0) {
                            echo $num['dating'] + $num['firefighter'];
                        } ?></span>
                </div>
            </a>
        </div>
    </div>
    <div class="function-list">
        <div class="row member-list">
            <a href="/weixin/firefighters/index-test" style="color:#04bf35;">
                <div class="col-sm-2 col-xs-2">
                    <span><img style="width: 25px;margin-left: -2px"
                               src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAFQ0lEQVRoge1Ya2yTVRh+3q9du0sHW92wA7pNRiagzAAmihfCZrYBjnAxURQ0YRCCECMGiJgYmb8MXkJEcYpCjBJjglw0QjcwUcMPyYIiqImEjdENEAZUuw06u37n8cec9PK1Wy/TxPRJ3h/fOc95z/Oc9+s55yuQRhpppJFGEpB4B7zXvarArJvnCfggiKkQKQU5eqCXVwF0iUg7KS0CzbXc/vZPKdYcgmEb2OlZ9QAg60GZD8AUxxw/Q7g9N9+z61HZ449fYmwMaaDx0uoxZjPfFXBRUjMR7Rq4vL7w/W+TyhOGmAY+uLLqYYK7AIxJ0XwK4NYLBeM3NUhDIBUJoxrY0bWinsAOxPe6DAsEv7QX9jySildKM2psvLS8TlHtIJWJVEh1gKzzdNl2JiseMKhA49WnxjGAUwDsqZggFgiuXOv4OCkjEQa2X1q2G8RSI/LpVg8ONLUCABbMmYhJE409nm714PPmVihFLJ5XjvKy/GjzX7MG/ixf6dzjSUx+2Cu0reOxMqWrx5VSMIovDrehp9ePnl4/9h86Y8hRSmG/6wy6e/zovd6P/a7oPKXULT4xP52o+AgD1OQJRV1T1GEUAEMGR+cFJ2VUnqIOBWVY7YQMKBWoUkpHtJj7UAlybRnItWVgfk1JVF5dTSlybRbkZGegrrY0Ku/vmPxWx5KxiRoI+Q284V58Ganb84cNDVL9XMnerxIZG2LgtXML+kGYUyMrEqPNt6Is8x6Ms06G3eyEzWSHSTJAqH6B1gmRXwgcha7vzczMPDucnCEGtrTV9QCwpVq4w1KOmaOWoDizInzKaCCAI0pkc7bFciwWMWS1FfUOAFMSVhqeXCyYlVePClstAAnbAmJCANQIWX2jr68xy2pdLyJ9hnMEPyilWgCmxIBVy8aiggYUWSeBBMJ3sGFCAKzx+f3TPORcu4g3nBC6jQr3KSokGwINCws2w5FxO6iYfOhqptXXd5CkJdxASAUC5/0ucUgrgImJLNcg7stbOiCeN1f9bHs7mg43gyTm1tZiwm0TIsadc5/DoaYmgMScSM79vTduvATgxeDGkAo0VH4TUHrghZgHzxBhM9kx3bYwoiqu5iZ4vV50d3fjoMtlWDlXczO8Xi+83d1wNTdH9JPc4PH5iqMaAICX7zz6mVLq0xjHf8y4I7sGGswgGRGD0HXdsD+YE6XfagoE6mMaAABTn28Fqb5L5KpcbJkGpRgRVbMrkZWVhezsbNRUVxtzKgc4OTk5qJpdacihYm2w1qib8vPHZ4zWLOZ9AlRF4xjhmfH7YNVy4hkSL/6w5+X9c701rAAAbLn7e6/1WlYtqPbGU4EMZBmuXApjVLDOqAaAgR+1Th6JZwvtDfye9DY8RFwJ1jjkvUdRnyU33zQCOEZBvhCTjPhd/jaUWKcPlTZxCH4MfoxtgBCc4EMcOEVbhNqzr8744RgAbDhZMQa6qUKjchJSKEIBNK9f992lyNUjpZ8KB4KfY96sNp2amh/o11pE8ErOtJMfNgjUUBN0dXXZ+smzAAqT1GqY3kROcDgc1wcb4v5rcTg4f/HykxB+lOq8FCx1OhyfBLeNiAEA6Ljw2zsQJPW9GwKisXhc0Zrw5hEzQNLUefHimwTWpiDdtuKxY9eJSMSVdsQMDMLd2bmMkK0AChLLwNdLnc6N0XpjngOpQInTubu/z1emqDYqslORiCcIXImVf8QrEAySWpvbfa+IzCK0KQIWAcgC6BXIVYInABwXoIiQBgx8HR4pKymu+Td1pgRfk+Y2t3tdq9v963+tJY000kjjf4y/ABnxFbzdzXEEAAAAAElFTkSuQmCC"></span>
                </div>
                <div class="col-sm-10 col-xs-10" style="line-height: 25px;">微信认证</div>
            </a>
        </div>
        <div class="row member-list">
            <a href="user/user-file">
                <div class="col-sm-2 col-xs-2" style="font-size: 16px;">
                    <span class="glyphicon glyphicon-user"></span>
                </div>
                <div class="col-sm-10 col-xs-10">档案资料</div>
            </a>
        </div>
        <div class="row member-list">
            <a href="user/system-msg">
                <div class="col-sm-2 col-xs-2" style="font-size: 16px;">
                    <span class="glyphicon glyphicon-volume-up"></span>
                </div>
                <div class="col-sm-10 col-xs-10">系统消息<span class="badge pull-right" style="background-color: red;"><?php if ($num['system'] != 0) {echo $num['system'];} ?></span></div>
            </a>
        </div>
    </div>
<?= $this->render('@app/themes/basic/layouts/bottom') ?>
<?php
$this->registerJs("
    $('#credit-intro').click(function () {
        alert('暂未开放');
    });
");
?>
