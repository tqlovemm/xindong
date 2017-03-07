<?php
    $this->title = "身份核实（绝对保密）";
$this->registerCss("
    #verification_button{display:block;margin-left: 5px;height: 44px;vertical-align: middle;color:gray;font-size:14px;line-height:44px;padding:0 10px;border:none;}
");
?>
<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
<link rel="stylesheet" href="/js/chi/loaders.min.css"/>
<link rel="stylesheet" href="/js/chi/loading.css"/>
<?php $this->registerJsFile('js/jquery.wallform.js', ['depends' => ['frontend\assets\AppAsset'], 'position' => $this::POS_HEAD]); ?>
<div class="row">
    <div id="header" style="padding:5px 10px;background-color: #f58611;text-align: center;color:#fff;font-size: 20px;font-weight: bold;"><?=$this->title?></div>
    <div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">手机号</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input id="cellphone" class="weui_input" type="number" name="cellphone" pattern="[0-9]*" placeholder="请输入手机号"/>
            </div>
        </div>
        <div class="weui_cell weui_vcode">
            <div class="weui_cell_hd"><label class="weui_label">验证码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input id="code" class="weui_input" type="number" name="code" placeholder="验证码"/>
            </div>
            <div class="weui_cell_ft">
                <input id="verification_button" class="btn btn-default" type="button" value="获取验证码">
            </div>
        </div>
    </div>
    <div class="bd spacing" style="margin-top: 20px;">
        <a onclick="next_step()" style="width: 94%;background-color: #f58611;" href="javascript:;" class="weui_btn weui_btn_primary">下一步</a>
    </div>
</div>

<div class="loading loader-chanage">
    <div class="loader">
        <div class="loader-inner pacman">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>
<script>
    $(window).load(function(){
        $(".loading").addClass("loader-chanage");
        $(".loading").fadeOut(300);
    });
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
            sendCode($("#verification_button"));
        });
        v = getCookieValue("verification_button_login") ? getCookieValue("verification_button_login") : 0;//获取cookie值
        if(v>0){
            settime($("#verification_button"));//开始倒计时
        }
    };

    function next_step() {
        var mobile = $("#cellphone").val();
        var code = $("#code").val();
        var url = '/bgadmin/verification/judge-true';
        if(noEmpty()){
            var judge = doPostBack(url,{'mobile':mobile,'code':code});
            if(judge){
                window.location.href = "/bgadmin/verification/url";
            }
        }else {
            alert('手机号和验证码不可为空');
        }
    }

    function sendCode(obj){
        var site = '/bgadmin/verification/';
        var mobile = $("#cellphone").val(); //检查手机是否合法
        if(isPhoneNum(mobile)){
            var send = doPostBack(site + 'save-session', {'mobile': mobile});
            if(send){
                addCookie('verification_button_login', 60, 60);//添加cookie记录,有效时间60s
                settime(obj);//开始倒计时
            }
        }
    }

    function doPostBack(url,queryParam) {
        var exist_01 = false;
        $.ajax({
            cache : false,
            type : 'POST',
            async : false,
            url : url,
            dataType:'text',
            data:queryParam,
            error : function(){
            },
            success:function(result){
                var parsedJson = $.parseJSON(result);
                if(parsedJson.statusCode=="000000"){
                    exist_01 = true;
                }else {
                    alert(parsedJson.statusMsg)
                }
            }
        });
        return exist_01;
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

    function noEmpty() {
        var mobile = $("#cellphone").val();
        var code = $("#code").val();

        if(mobile==""||code==""){
            return false;
        }
        return true;
    }

    function isPhoneNum(obj){
        var myreg = /^(((13[0-9]{1})|(14[0-9]{1})|(15[0-9]{1})|(16[0-9]{1})|(17[0-9]{1})|(18[0-9]{1})|(19[0-9]{1}))+\d{8})$/;
        if(!myreg.test(obj)){
            alert('请输入有效的手机号码！');
            $("#cellphone").focus();
            return false;
        }else{
            return true;
        }
    }
</script>
