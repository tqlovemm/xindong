<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = '管理员登陆';
$this->registerCss("

");
?>
<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
<div class="login-box">
    <div class="login-logo">
        <a href="#" style="color: #fff;"><b>十三平台</b>后台管理系统</a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg" style="font-size: 14px;padding: 0 0 15px 0;">为保障账号安全，请管理员每月修改一次密码</p>
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?= $form->field($model, 'username', [
                'inputOptions' => [
                    'placeholder' => $model->getAttributeLabel('username'),
                ]
            ])->label(false); ?>

            <?= $form->field($model, 'password', [
                'inputOptions' => [
                    'placeholder' => $model->getAttributeLabel('password'),
                ]
            ])->passwordInput()->label(false); ?>
        <?= $form->field($model, 'verification', [
            'template' => '<div class="input-group">
                          {input}<input id="verification_button" class="btn btn-default pull-left" type="button" value="获取验证码"></div>{error}',
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('verification'),
            ],
        ])->label(false);
        ?>
        <div class="row">
            <div class="weui_msg">
                <div class="weui_opr_area">
                    <p class="weui_btn_area">
                        <?= Html::submitButton('登录', ['class' => 'weui_btn weui_btn_primary', 'name' => 'login-button']) ?>
                    </p>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<script>
    function addCookie(name,value,expiresHours){
        var cookieString=name+"="+escape(value); //判断是否设置过期时间,0代表关闭浏览器时失效
        if(expiresHours>0){
            var date=new Date();
            date.setTime(date.getTime()+expiresHours*1000);
            cookieString=cookieString+";expires=" + date.toUTCString();
        }
        document.cookie=cookieString;
    }
    //修改cookie的值
    function editCookie(name,value,expiresHours){
        var cookieString=name+"="+escape(value);
        if(expiresHours>0){
            var date=new Date();
            date.setTime(date.getTime()+expiresHours*1000); //单位是毫秒
            cookieString=cookieString+";expires=" + date.toGMTString();
        }
        document.cookie=cookieString;
    }//根据名字获取cookie的值
    function getCookieValue(name){
        var strCookie=document.cookie;
        var arrCookie=strCookie.split("; ");
        for(var i=0;i<arrCookie.length;i++){
            var arr=arrCookie[i].split("=");
            if(arr[0]==name){
                return unescape(arr[1]);
                break;
            }
        }
    }
    window.onload=function(){

        $("#verification_button").click(function (){

            sendCode();
        });
        v = getCookieValue("verification_button_login") ? getCookieValue("verification_button_login") : 0;//获取cookie值
        if(v>0){
            settime($("#verification_button"));//开始倒计时
        }
    };

    function sendCode(){

        var site = '<?=Yii::$app->params['hostname']?>/bgadmin/verification/';
        var mobile = $("#loginform-username").val(); //检查手机是否合法
        doPostBack(site + 'save-se', {'mobile': mobile});
    }

    function doPostBack(url,queryParam) {

        $.ajax({
            type:'get',
            async: false,
            url:url+'?mobile='+queryParam.mobile,
            dataType:'jsonp',
            processData: true,
            jsonp: "callbackparams",
            success:function(result){
                console.log(result);
                if(result.statusCode==0){
                        addCookie('verification_button_login', 5, 5);//添加cookie记录,有效时间60s
                        settime($("#verification_button"));//开始倒计时
                }else {
                    alert(result.statusMsg)
                }
            },
            error:function(XMLHttpRequest, textStatus) {
                alert(XMLHttpRequest.status);
                alert(XMLHttpRequest.readyState);
                alert(textStatus);
            }
        });

    }

    var countdown;
    function settime(obj) {
        countdown = getCookieValue('verification_button_login') ? getCookieValue('verification_button_login') : 0;
        if (countdown == 0) {
            obj.removeAttr('disabled');
            obj.val("获取验证码");
            return;
        } else {
            obj.attr('disabled', true);
            obj.val(countdown + "秒后重发");
            countdown--;
            editCookie("verification_button_login", countdown, countdown + 1);
        }
        setTimeout(function () {
            settime(obj)
        }, 1000); //每1000毫秒执行一次
    }
</script>