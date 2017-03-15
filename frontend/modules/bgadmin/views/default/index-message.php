<?php
$this->title = "地方啪入会申请表";
$this->registerCss('
    .navbar.navbar-custom ,footer,#izl_rmenu{display:none;}
    .preview{border:solid 1px #dedede;padding:10px;height:75px;width:75px;margin-right: 9px;margin-bottom: 9px;float:left;}
    .btn{position: relative;overflow: hidden;margin-right: 4px;display:inline-block;*display:inline;padding:6px 10px;font-size:14px;line-height:18px;*line-height:20px;color:#fff;text-align:center;vertical-align:middle;cursor:pointer;border:1px solid #cccccc;border-color:#e6e6e6 #e6e6e6 #bfbfbf;border-bottom-color:#b3b3b3;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;}
    .btn input {position: absolute;top: 0; right: 0;margin: 0;border: solid transparent;opacity: 0;filter:alpha(opacity=0); cursor: pointer;}
    #imageform .form-control{margin-bottom:5px;}
    .weui_btn_area{margin:0 !important;}
    .weui_cells_radio p{margin:0;}
    #main label{margin-bottom:0}
    .weui_cells{font-size:14px !important;}
    .d-arr {display: inline-block;width: 6px;height: 6px;border-top: 1px solid #9d9d9d;border-right: 1px solid #9d9d9d;margin-left: 2px;}
    .d-arr {-webkit-transform: rotate(135deg);-webkit-transition: all .3s;}
    .up em {top: 1px;-webkit-transform: rotate(-45deg);transform: rotate(-45deg);}
    .label-makefriend-span{background-color: #ff904e;padding:1px 4px;border-radius: 3px;margin-right: 5px;}
');
$pre_url = Yii::$app->params['shisangirl'];
?>
<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
<?php $this->registerJsFile('js/jquery.wallform.js', ['depends' => ['frontend\assets\AppAsset'], 'position' => $this::POS_HEAD]); ?>
<div id="header" style="padding:10px;background-color: #d03490;text-align: center;color:#fff;font-size: 20px;font-weight: bold;"><?=$this->title?></div>
<div id="main" style="padding:10px;background-color: #fbf9fe;">
    <b>下面的一些问题可能会触及到你的隐私，但请放心我们会绝对保密，仅用于平台内部。</b>
    <div id="up_status" style="display:none"><img src="/images/loader.gif" alt="uploading"/></div>
    <div class="demo">
        <form id="imageform" method="post" enctype="multipart/form-data" action="/bgadmin/default/uploader">
            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_bd weui_cell_primary">
                        <div class="weui_uploader">
                            <div class="weui_uploader_hd weui_cell">
                                <div class="weui_cell_bd weui_cell_primary">个人照片上传<small> （单张上传至少2张，点击图片可删除，最好包含身材照哟，不可含有联系方式，第一张作为封面头像要最好看的，照片越多越能匹配优质汉子，如果想要保护隐私可联系客服不发布）</small></div>
                                <div class="weui_cell_ft weui_cell_fts"><span><?= count($img)?></span>/6</div>
                            </div>
                            <div class="weui_uploader_bd">
                                <div class="weui_uploader_files" id="preview">
                                    <?php if(!empty($img)): foreach ($img as $item):?>
                                        <img onclick="delete_img(<?=$item['id']?>)"  src="<?=$pre_url.$item['path']?>" data-id="<?=$item['id']?>" class="preview collecting-files-img">
                                    <?php endforeach;endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form id="imageweima" method="post" enctype="multipart/form-data" action="/bgadmin/default/uploader-weima">
            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_bd weui_cell_primary">
                        <div class="weui_uploader">
                            <div class="weui_uploader_hd weui_cell">
                                <div class="weui_cell_bd weui_cell_primary">微信名片二维码<small> （点击图片可删除，挑中喜欢的男生后，男生会收到你的二维码）</small></div>
                                <div class="weui_cell_ft weui_cell_ftsw"><span><?php if(!empty($img)){echo 1;}else{echo 0;}?></span>/1</div>
                            </div>
                            <div class="weui_uploader_bd">
                                <div class="weui_uploader_files" id="preview_weima">
                                    <?php if(!empty($weima)):?>
                                        <img src="<?=$pre_url.$weima['path']?>" data-id="<?=$weima['id']?>" class="preview">
                                    <?php endif;?>
                                </div>
                                <?php if(empty($weima)):?>
                                    <div class="weui_uploader_input_wrp btn" id="up_btn_weima">
                                        <input type="hidden" value="<?=$queries['id']?>" name="id">
                                        <input class="weui_uploader_input" type="file" id="weimaimg" name="weimaimg" accept="image/*" multiple />
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form method="post" action="/bgadmin/default/text?id=<?=$queries['id']?>" onsubmit="return validate_form(this);">
            <div class="form-group">

                <div class="weui_cells_title">选择<small>（可以翻牌所在地区的男生）</small></div>
                <div class="weui_cells">
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label for="" class="weui_label">地区一<small style="color: red;"> （必填）</small></label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" type="number" name="age" value="<?=$queries['title']?>" placeholder="请输入您的年龄"/>
                        </div>
                    </div>
                </div>
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell weui_cell_select weui_select_after">
                        <div class="weui_cell_hd">
                            <label for="" class="weui_label">罩杯<small> （选填）</small></label>
                        </div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <select class="weui_select" name="cup">
                                <option value="">请选择</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                            </select>
                        </div>
                    </div>
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label for="" class="weui_label">年龄<small style="color: red;"> （必填）</small></label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" type="number" name="age" value="" placeholder="请输入您的年龄"/>
                        </div>
                    </div>
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label">身高<small style="color: red;"> （必填）</small></label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" type="number" name="height" pattern="[0-9]*" value="" placeholder="请输入身高cm"/>
                        </div>
                    </div>
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label">体重<small style="color: red;"> （必填）</small></label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" type="number" name="weight" pattern="[0-9]*" value="" placeholder="请输入体重kg"/>
                        </div>
                    </div>
                </div>
                <div class="weui_cells_title">职业<small> （隐私保护）</small></div>
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_bd weui_cell_primary">
                            <textarea class="weui_textarea" maxlength="15" name="job" placeholder="学生请填写无" rows="1"></textarea>
                            <div class="weui_textarea_counter"><span>0</span>/15</div>
                        </div>
                    </div>
                </div>
                <div class="weui_cells_title">交友要求<small style="color: red;"> （必选，最多选择4个）</small></div>
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell adjustArrow">
                        <div class="weui_cell_bd weui_cell_primary">
                            <div class="make_friend_choice" style="height: 18px;"></div>
                            <input id="mark_friend_label" type="hidden" value="" name="mark_friend_label">
                        </div>
                        <em class="d-arr" onclick="adjustArrow()"></em>
                    </div>
                </div>

                <script>
                    function changeLabel(content) {
                        var con = $(content);
                        var first_label = $('.make_friend_choice span').eq(0);
                        var index_label = con.parents('.label-makefriend').length;

                        con.remove();
                        if(index_label>0){
                            $('.make_friend_choice').append(con);
                            $('#mark_friend_label').val($('#mark_friend_label').val()+con.html()+'，');
                        }else {
                            $('.label-makefriend').append(con);

                            $('#mark_friend_label').val($('#mark_friend_label').val().replace(con.html()+'，',""));
                        }
                        if($('.make_friend_choice').children().length>4){
                            first_label.remove();
                            $('.label-makefriend').append(first_label);
                            $('#mark_friend_label').val($('#mark_friend_label').val().replace(first_label.html()+'，',""));
                        }
                    }

                    function adjustArrow() {
                        if($('.adjustArrow').hasClass('up')){
                            $('.adjustArrow').removeClass('up');
                            $('.label-makefriend').slideUp();
                        }else {
                            $('.adjustArrow').addClass('up');
                            $('.label-makefriend').slideDown();
                        }
                    }
                </script>
                <div class="weui_cells_title">兴趣爱好</div>
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_bd weui_cell_primary">
                            <textarea class="weui_textarea" maxlength="15" name="hobby" placeholder="兴趣爱好" rows="1"></textarea>
                            <div class="weui_textarea_counter"><span>0</span>/15</div>
                        </div>
                    </div>
                </div>
                <div class="weui_cells_title">喜欢什么样的男生</div>
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_bd weui_cell_primary">
                            <textarea class="weui_textarea" maxlength="100" name="like_type" placeholder="越详细越好" rows="3"></textarea>
                            <div class="weui_textarea_counter"><span>0</span>/100</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="weui_btn_area">
                <input class="weui_btn weui_btn_primary" id="submit_text" type="submit" value="确认提交">
            </div>
        </form>

        <div class="weui_dialog_alert" id="dialog" style="display: none;">
            <div class="weui_mask"></div>
            <div class="weui_dialog">
                <div class="weui_dialog_hd"><strong class="weui_dialog_title">警告</strong></div>
                <div class="weui_dialog_bd notice_content">微信号不可为空</div>
                <div class="weui_dialog_ft">
                    <a href="javascript:;" class="weui_btn_dialog primary iknow">确定</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $('.iknow').click(function () {

        $('#dialog,#dialog__delete').hide();
    });

    function delete_img(id){

        if(confirm('确认删除')){
            $.get('/bgadmin/default/delete?id='+id, function (data) {
                history.go(0);
            });
        }

    }

    function validate_required(field,alerttxt)
    {

        with (field)
        {
            if (value==null||value=="")
            {
                $('.notice_content').html(alerttxt);
                $('#dialog').show();return false}
            else {return true}
        }
    }

    function validate_form(thisform)
    {
        with (thisform)
        {
            if (validate_required(title,'地区一为必选内容')==false)
            {title.focus();return false}

            if (validate_required(age,'年龄为必选内容')==false)
            {age.focus();return false}
            if (validate_required(height,'身高不可为空')==false)
            {height.focus();return false}
            if (validate_required(weight,'体重不可为空')==false)
            {weight.focus();return false}
            if (validate_required(mark_friend_label,'交友要求不可为空')==false)
            {mark_friend_label.focus();return false}
        }

    }

    $('#submit_text').click(function () {

        if($('#preview img').size()<2){
            $('.notice_content').html('上传图片数量不可小于2张');
            { $('#dialog').show();return false}
        }
        if($('#preview_weima img').size()<1){
            $('.notice_content').html('微信名片二维码为必传资料');
            { $('#dialog').show();return false}
        }

    });

    $(function () {

        $('.weui_textarea',this).keyup(function () {
            $(this).siblings('.weui_textarea_counter').children('span').html( $(this).val().length);
        });

        $('#photoimg').on('change', function(){
            var status = $('#up_status');
            var btn = $('#up_btn');
            $('#imageform').ajaxForm({
                target: '#preview',
                beforeSubmit:function(){
                    status.show();
                    btn.hide();
                },
                success:function(){
                    status.hide();
                    if( $('#preview img').size()>=6 ){
                        btn.hide();
                    }else {
                        btn.show();
                    }
                    $('.weui_cell_fts span').html($('#preview img').size());
                },
                error:function(){
                    status.hide();
                    btn.show();
                }
            }).submit();
        });
        $('#weimaimg').on('change', function(){
            var status = $('#up_status');
            var btn = $('#up_btn_weima');
            $('#imageweima').ajaxForm({
                target: '#preview_weima',
                beforeSubmit:function(){
                    status.show();
                    btn.hide();
                },
                success:function(){
                    status.hide();
                    if( $('#preview_weima img').size()>=1 ){
                        btn.hide();
                    }else {
                        btn.show();
                    }
                    $('.weui_cell_ftsw span').html($('#preview_weima img').size());
                },
                error:function(){
                    status.hide();
                    btn.show();
                }
            }).submit();
        });
    });

    /*$(".collecting-files-img").on('click',function(e){
     if(confirm('确定删除吗')) {
     $.get('/collecting-files/delete?id=' + $(this).attr('data-id'), function (data) {
     history.go(0);
     });
     }
     });*/

    $('#preview_weima').on('click',function () {
        if(confirm('确定删除吗')){
            $.get('/bgadmin/default/delete-weima?id='+$('#preview_weima .preview').attr('data-id'),function (data) {
                history.go(0);
            });
        }
    })
</script>