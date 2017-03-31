<?php

$this->title = "十七高端社交";
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
    
');
$pre_url = Yii::$app->params['qiniushiqi'];
?>
<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
<?php $this->registerJsFile('js/jquery.wallform.js', ['depends' => ['frontend\assets\AppAsset'], 'position' => $this::POS_HEAD]); ?>
<div id="header" style="padding:10px;background-color: #f58611;text-align: center;color:#fff;font-size: 20px;font-weight: bold;">我要约会 | 从填表单开始<br>
    【十七高端社交】</div>
<div id="main" style="padding:10px;background-color: #fbf9fe;">
    <b>以下是宝贝需要填写的个人信息，必须详细真实，请不要心急，慢慢填哦！</b>
    <div id="up_status" style="display:none"><img src="/images/loader.gif" alt="uploading"/></div>
    <div class="demo">
        <form id="imageform" method="post" enctype="multipart/form-data" action="/collecting-seventeen-files/uploader">
            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_bd weui_cell_primary">
                        <div class="weui_uploader">
                            <div class="weui_uploader_hd weui_cell">
                                <div class="weui_cell_bd weui_cell_primary">个人照上传</div>
                                <div class="weui_cell_ft weui_cell_fts"><span><?=count($img)?></span>/6</div>
                            </div>
                            <div style="color:gray;font-size: 12px;margin-bottom: 5px;">(至少4张，包含身材照和脸照,不可含有联系方式，第一张作为封面头像要最好看哦)</div>
                            <div class="weui_uploader_bd">
                                <div class="weui_uploader_files" id="preview">
                                    <?php
                                        if(!empty($img)):
                                            foreach ($img as $item):
                                    ?>
                                        <img src="<?=$pre_url.$item['img']?>" onclick="deleteImg(<?=$item['id']?>)" class="preview collecting-files-img">
                                    <?php
                                            endforeach;
                                        endif;
                                    ?>
                                </div>
                                <?php if(count($img)<6):?>
                                <div class="weui_uploader_input_wrp btn" id="up_btn">
                                    <input type="hidden" value="<?=$queries['id']?>" name="id">
                                    <input class="weui_uploader_input" type="file" id="photoimg" name="photoimg" accept="image/*" multiple />
                                </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form id="imageform2" method="post" action="/collecting-seventeen-files/uploadw">

            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_bd weui_cell_primary">
                        <div class="weui_uploader">

                            <div class="weui_uploader_hd weui_cell" style="padding-bottom: 5px;">
                                <div class="weui_cell_bd weui_cell_primary">微信二维码图片</div>
                                <div class="weui_cell_ft weui_cell_ft2"><span><?=count($wei_img)?></span>/1</div>
                            </div>
                            <div style="color: gray;margin-bottom: 5px;font-size: 13px;">(上传微信二维码名片，方便我们更快更准确的为您服务)</div>
                            <div class="weui_uploader_bd">
                                <div class="weui_uploader_files" id="preview2">
                                    <?php
                                    if(!empty($wei_img)):
                                        foreach ($wei_img as $key=>$item): ?>
                                            <img src="<?=$pre_url.$item['img']?>" onclick="deleteImg(<?=$item['id']?>)" class="preview collecting-files-img">
                                        <?php endforeach;endif;?>
                                </div>
                                <?php if(count($wei_img)<1):?>
                                    <div class="weui_uploader_input_wrp btn" id="up_btn2">
                                        <input type="hidden" value="<?=$queries['id']?>" name="wid">
                                        <input class="weui_uploader_input" type="file" id="weimaimg" name="weimaimg" accept="image/*" multiple />
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form method="post" action="/collecting-seventeen-files/text?id=<?=$queries['id']?>" onsubmit="return validate_form(this);">
            <div class="form-group">
                <div class="weui_cells_title">当前所在地区<small style="color:red;">（必选）</small></div>
                <div class="weui_cells">
                    <div class="weui_cell weui_cell_select">
                        <div class="weui_cell_bd weui_cell_primary distpicker" data-toggle="distpicker">
                            <select class="weui_select" style="width: 50%;float:left;padding-right:0" name="address_province" data-province="---- 选择省份 ----"></select>
                            <select class="weui_select" style="width: 50%;float:left;padding-left:0" name="address_city" data-city="---- 选择市区 ----"></select>
                        </div>
                    </div>
                </div>
                <div class="weui_cells_title">可去地区一<small style="color:red;">（选填）</small></div>
                <div class="weui_cells">
                    <div class="weui_cell weui_cell_select">
                        <div class="weui_cell_bd weui_cell_primary distpicker" data-toggle="distpicker">
                            <select class="weui_select" style="width: 50%;float:left;padding-right:0" name="address_province2" data-province="---- 选择省份 ----"></select>
                            <select class="weui_select" style="width: 50%;float:left;padding-left:0" name="address_city2" data-city="---- 选择市区 ----"></select>
                        </div>
                    </div>
                </div>
                <div class="weui_cells_title">可去地区二<small style="color:red;">（选填）</small></div>
                <div class="weui_cells">
                    <div class="weui_cell weui_cell_select">
                        <div class="weui_cell_bd weui_cell_primary distpicker" data-toggle="distpicker">
                            <select class="weui_select" style="width: 50%;float:left;padding-right:0" name="address_province3" data-province="---- 选择省份 ----"></select>
                            <select class="weui_select" style="width: 50%;float:left;padding-left:0" name="address_city3" data-city="---- 选择市区 ----"></select>
                        </div>
                    </div>
                </div>
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label">微信<small style="color:red;">（选填）</small></label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" name="weichat" placeholder="请输入微信号"/>
                        </div>
                    </div>
                </div>
                <div class="weui_cells">

                    <div class="weui_cell weui_cell_select weui_select_after">
                        <div class="weui_cell_hd">
                            <label for="" class="weui_label">年龄<small style="color:red;">（必选）</small></label>
                        </div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <select title="education" class="weui_select" name="age">
                                <option value="">请选择年龄</option>
                                <?php for($i=16;$i<56;$i++):?>
                                    <option value="<?=$i?>"><?=$i?>岁</option>
                                <?php endfor;?>
                            </select>
                        </div>
                    </div>
                    <div class="weui_cell weui_cell_select weui_select_after">
                        <div class="weui_cell_hd">
                            <label for="" class="weui_label">身高<small style="color:red;">（必选）</small></label>
                        </div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <select title="education" class="weui_select" name="height">
                                <option value="">请选择身高</option>
                                <?php for($i=150;$i<200;$i++):?>
                                    <option value="<?=$i?>"><?=$i?>cm</option>
                                <?php endfor;?>
                            </select>
                        </div>
                    </div>
                    <div class="weui_cell weui_cell_select weui_select_after">
                        <div class="weui_cell_hd">
                            <label for="" class="weui_label">体重<small style="color:red;">（必选）</small></label>
                        </div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <select title="education" class="weui_select" name="weight">
                                <option value="">请选择体重</option>
                                <?php for($i=35;$i<121;$i++):?>
                                    <option value="<?=$i?>"><?=$i?>kg</option>
                                <?php endfor;?>
                            </select>
                        </div>
                    </div>
                    <div class="weui_cell weui_cell_select weui_select_after">
                        <div class="weui_cell_hd">
                            <label for="" class="weui_label">罩杯<small style="color:red;">（必选）</small></label>
                        </div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <select title="cup" class="weui_select" name="cup">
                                <option value="">选择罩杯</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                                <option value="G">G</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="weui_cells">

                    <div class="weui_cell weui_cell_select weui_select_after">
                        <div class="weui_cell_hd">
                            <label for="" class="weui_label">学历<small style="color:red;">（必选）</small></label>
                        </div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <select title="education" class="weui_select" name="education">
                                <option value="">请选择</option>
                                <option value="研究生及以上">研究生及以上</option>
                                <option value="本科">本科</option>
                                <option value="专科">专科</option>
                                <option value="高中及以下">高中及以下</option>
                            </select>
                        </div>
                    </div>

                    <div class="weui_cell weui_cell_select weui_select_after">
                        <div class="weui_cell_hd">
                            <label for="" class="weui_label">啪过<small style="color:red;">（必选）</small></label>
                        </div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <select title="cup" class="weui_select" name="already_pa">
                                <option value="">啪过几个</option>
                                <option value="0">无</option>
                                <option value="1">1个</option>
                                <option value="2">2个</option>
                                <option value="3">3个</option>
                                <option value="4">4个</option>
                                <option value="5">5个</option>
                                <option value="6">6个</option>
                                <option value="7">7个</option>
                                <option value="8">8个</option>
                                <option value="9">9个</option>
                                <option value="10">10个或以上</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="weui_cells_title">职业信息<small style="color:red;">（必填）</small></div>
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_bd weui_cell_primary">
                            <textarea class="weui_textarea" maxlength="50" name="job_detail" placeholder="如：学生（学校年级）；工作（职业岗位）" rows="2"></textarea>
                            <div class="weui_textarea_counter"><span>0</span>/50</div>
                        </div>
                    </div>
                </div>
                <div class="weui_cells_title">资助费<small style="color:red;">（必填）</small></div>
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_bd weui_cell_primary">
                            <textarea class="weui_textarea" maxlength="100" name="pay" placeholder="单次，单天，单月。接受最低费用！" rows="3"></textarea>
                            <div class="weui_textarea_counter"><span>0</span>/100</div>
                        </div>
                    </div>
                </div>
                <div class="weui_cells_title">备注</div>
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_bd weui_cell_primary">
                            <textarea class="weui_textarea" maxlength="100" name="extra" placeholder="更详细的了解你" rows="3"></textarea>
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

    $(function () {
       $('.distpicker select').val('');
    });

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
            if (validate_required(address_province,'地区不可为空')==false)
            {address_province.focus();return false}
            if (validate_required(weichat,'微信号不可为空')==false)
            {weichat.focus();return false}
            if (validate_required(age,'生日不可为空')==false)
            {age.focus();return false}
            if (validate_required(height,'身高不可为空')==false)
            {height.focus();return false}
            if (validate_required(weight,'体重不可为空')==false)
            {weight.focus();return false}
            if (validate_required(cup,'罩杯不可为空')==false)
            {cup.focus();return false}
            if (validate_required(education,'学历不可为空')==false)
            {education.focus();return false}
            if (validate_required(already_pa,'啪过几个不可为空')==false)
            {already_pa.focus();return false}
            if (validate_required(job_detail,'职业不可为空')==false)
            {job_detail.focus();return false}
            if (validate_required(pay,'资助费不可为空')==false)
            {pay.focus();return false}

        }

    }


    $('.iknow').click(function () {

        $('#dialog,#dialog__delete').hide();
    });


    $('#submit_text').click(function () {

        if($('#preview img').size()<4){
            $('.notice_content').html('上传图片数量不可小于4张');
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
                } }).submit();
        });
        $('#weimaimg').on('change', function(){
            var btn = $('#up_btn2');
            $('#imageform2').ajaxForm({
                target: '#preview2',
                beforeSubmit:function(){
                    btn.hide();
                },
                success:function(){
                    if( $('#preview2 img').size()>=1 ){
                        btn.hide();
                    }else {
                        btn.show();
                    }
                    $('.weui_cell_ft2 span').html($('#preview2 img').size());
                },
                error:function(){
                    btn.show();
                } }).submit();
        });

    });

    function deleteImg(id) {
        if(confirm('确定删除吗')){
            $.get('/collecting-seventeen-files/delete?id='+id,function (data) {
                history.go(0);
            });
        }
    }

</script>