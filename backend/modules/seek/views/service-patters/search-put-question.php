<?php

$this->title = "提问";

$this->registerCss("
    .login-page, .register-page {background-color: #eee;}
    .container{width:100%;}
    .member-center header{background-color:#fff !important;height:40px !important;}
    .member-center header h4{text-align:center;line-height:40px;}
    .member-center header a,.member-center header h5{color: #eee !important;line-height:40px;padding:0 10px;}
");
?>
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
    <div class="push-comments">
        <div class="row member-center">
            <header>
                <div class="header" style="background-color: #37b059;color: #eee;position: relative;">
                    <a style="position: absolute;top:0;left:3%;" href="javascript:history.back();">取消</a>
                    <h4 style="margin:0;text-align: center;color:#fff;"><?=$this->title?></h4>
                    <a href="http://13loveme.com:82/search/search.php" style="position: absolute;right:3%;top:0;">搜索</a>
                </div>
            </header>
        </div>
        <div class="row">
            <form method="post" action="put-questions">
                <div class="weui_cells weui_cells_form" style="margin-top: 0;">
                    <div class="weui_cell">
                        <div class="weui_cell_bd weui_cell_primary">
                            <textarea style="color:#5c5c5c;font-size: 14px;" class="weui_textarea" maxlength="128" name="content" required  placeholder="<?=$this->title?>" rows="5"></textarea>
                            <div class="weui_textarea_counter"><span>0</span>/128</div>
                        </div>
                    </div>
                </div>

                <div class="weui_btn_area">
                    <input class="weui_btn weui_btn_primary" id="submit_text" type="submit" value="确认提交">
                </div>
            </form>
        </div>
    </div><!-- push-comments -->
<?php
$this->registerJs("
    
        $('.weui_textarea',this).keyup(function () {
            $(this).siblings('.weui_textarea_counter').children('span').html( $(this).val().length);
        });
        $('#submit_text').on('click',function(){
            if($('.weui_textarea').val().length<3){
                alert('字数不可少于3');
                return false;
            }
        });
    
    ");
?>