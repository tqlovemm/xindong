<?php
$this->title = "十三平台入会申请表";
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
$pre_url = Yii::$app->params['imagetqlmm'];
?>
<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
<?php $this->registerJsFile('js/jquery.wallform.js', ['depends' => ['frontend\assets\AppAsset'], 'position' => $this::POS_HEAD]); ?>
<div id="header" style="padding:10px;background-color: #2695D0;text-align: center;color:#fff;font-size: 20px;font-weight: bold;"><?=$this->title?></div>
<div id="main" style="padding:10px;background-color: #fbf9fe;">
    <b>下面的一些问题可能会触及到你的隐私，但请放心我们会绝对保密，仅用于平台内部。填写的越详细越能吸引女生的注意哦！！</b>
    <div id="up_status" style="display:none"><img src="/images/loader.gif" alt="uploading"/></div>
    <div class="demo">
        <form id="imageform" method="post" enctype="multipart/form-data" action="/collecting-files/uploader">
            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_bd weui_cell_primary">
                        <div class="weui_uploader">
                            <div class="weui_uploader_hd weui_cell">
                                <div class="weui_cell_bd weui_cell_primary">档案照上传<small> （单张上传至少4张，第一张作为翻牌头像请选择优质图片，点击图片可删除）</small></div>
                                <div class="weui_cell_ft weui_cell_fts"><span><?= count($img)?></span>/6</div>
                            </div>
                            <div class="weui_uploader_bd">
                                <div class="weui_uploader_files" id="preview">
                                    <?php
                                        if(!empty($img)):
                                            foreach ($img as $item):
                                    ?>
                                        <img onclick="delete_img(<?=$item['id']?>)"  src="<?=$pre_url.$item['img']?>" data-id="<?=$item['id']?>" class="preview collecting-files-img">
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
        <form id="imageweima" method="post" enctype="multipart/form-data" action="/collecting-files/uploader-weima">
            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_bd weui_cell_primary">
                        <div class="weui_uploader">
                            <div class="weui_uploader_hd weui_cell">
                                <div class="weui_cell_bd weui_cell_primary">微信名片二维码<small> （点击图片可删除）</small></div>
                                <div class="weui_cell_ft weui_cell_ftsw"><span><?php if(!empty($queries['weima'])){echo 1;}else{echo 0;}?></span>/1</div>
                            </div>
                            <div class="weui_uploader_bd">
                                <div class="weui_uploader_files" id="preview_weima">
                                    <?php if(!empty($queries['weima'])):?>
                                        <img src="<?=$pre_url.$queries['weima']?>" data-id="<?=$queries['id']?>" class="preview">
                                    <?php endif;?>
                                </div>
                                <?php if(empty($queries['weima'])):?>
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

        <form method="post" action="/collecting-files/text?id=<?=$queries['id']?>" onsubmit="return validate_form(this);">
            <div class="form-group">
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label">微信号<small>（必填）</small></label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" id="weichat-text" type="text" name="weichat" value="<?=$queries['weichat']?>"  placeholder="请输入微信号"/>
                        </div>
                    </div>
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label">手机号<small>（必填）</small></label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" id="weichat-text" type="number" name="cellphone" value="<?=$queries['cellphone']?>"  placeholder="用于档案资料找回修改"/>
                        </div>
                    </div>
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label">邮箱<small>（必填）</small></label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" id="weichat-text" type="email" name="email" value="<?=$queries['email']?>"  placeholder="平台会给你福利哦"/>
                        </div>
                    </div>
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label">微博号</label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" type="text" name="weibo" value="<?=$queries['weibo']?>" placeholder="请输入微博号"/>
                        </div>
                    </div>
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label">Q Q号</label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" type="text" name="qq" value="<?=$queries['qq']?>" placeholder="请输入qq号"/>
                        </div>
                    </div>
                </div>
                <div class="weui_cells_title">选择</div>
                <div class="weui_cells">
                    <div class="weui_cell weui_cell_select weui_select_after">
                        <div class="weui_cell_hd">
                            <label for="" class="weui_label">年薪</label>
                        </div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <select class="weui_select" name="annual_salary">
                                <option value="">请选择</option>
                                <option value="10-20万">10-20万</option>
                                <option value="20-50万">20-50万</option>
                                <option value="50-100万">50-100万</option>
                                <option value="100">100-300万</option>
                                <option value="100-300万">300-500万</option>
                                <option value="300-500万">500-1000万</option>
                                <option value="1000万以上">1000万以上</option>
                            </select>
                        </div>
                    </div>
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label">车型</label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" type="text" name="car_type" value="<?=$queries['car_type']?>" placeholder="汽车哦，没有可不填"/>
                        </div>
                    </div>
                </div>
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label for="" class="weui_label">生日<small> （必选）</small></label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" type="date" name="age" value=""/>
                        </div>
                    </div>
                    <?php

                        if($queries['height']==0){
                            $queries['height'] = '';
                        }
                        if($queries['weight']==0){
                            $queries['weight'] = '';
                        }
                    ?>
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label">身高<small> （必填）</small></label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" type="number" name="height" maxlength="3" pattern="[0-9]*" value="<?=$queries['height']?>" placeholder="请输入身高cm"/>
                        </div>
                    </div>
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label">体重<small> （必填）</small></label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" type="number" name="weight" pattern="[0-9]*" value="<?=$queries['weight']?>" placeholder="请输入体重kg"/>
                        </div>
                    </div>
                </div>
                <div class="weui_cells_title">婚姻/对象情况（保密）</div>
                <div class="weui_cells weui_cells_radio">
                    <label class="weui_cell weui_check_label" for="x13">
                        <div class="weui_cell_bd weui_cell_primary">
                            <p>单身</p>
                        </div>
                        <div class="weui_cell_ft">
                            <input type="radio" name="marry" value="0" class="weui_check" id="x13" checked>
                            <span class="weui_icon_checked"></span>
                        </div>
                    </label>
                    <label class="weui_cell weui_check_label" for="x11">
                        <div class="weui_cell_bd weui_cell_primary">
                            <p>已婚</p>
                        </div>
                        <div class="weui_cell_ft">
                            <input type="radio" class="weui_check" name="marry" value="2" id="x11">
                            <span class="weui_icon_checked"></span>
                        </div>
                    </label>
                    <label class="weui_cell weui_check_label" for="x12">
                        <div class="weui_cell_bd weui_cell_primary">
                            <p>有女友</p>
                        </div>
                        <div class="weui_cell_ft">
                            <input type="radio" name="marry" value="1" class="weui_check" id="x12">
                            <span class="weui_icon_checked"></span>
                        </div>
                    </label>
                </div>
                <div class="weui_cells_title">职业</div>
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_bd weui_cell_primary">
                            <textarea class="weui_textarea" maxlength="15" name="job" placeholder="工作职业" rows="1"><?=$queries['job']?></textarea>
                            <div class="weui_textarea_counter"><span>0</span>/15</div>
                        </div>
                    </div>
                </div>
                <div class="weui_cells_title">经常出没</div>
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_bd weui_cell_primary">
                            <textarea class="weui_textarea" maxlength="15" name="often_go" placeholder="经常出没的地方" rows="1"><?=$queries['often_go']?></textarea>
                            <div class="weui_textarea_counter"><span>0</span>/15</div>
                        </div>
                    </div>
                </div>
                <div class="weui_cells_title">兴趣爱好</div>
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_bd weui_cell_primary">
                            <textarea class="weui_textarea" maxlength="15" name="hobby" placeholder="请输入兴趣爱好" rows="2"><?=$queries['hobby']?></textarea>
                            <div class="weui_textarea_counter"><span>0</span>/15</div>
                        </div>
                    </div>
                </div>
                <div class="weui_cells_title">期望女生类型</div>
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_bd weui_cell_primary">
                            <textarea class="weui_textarea" maxlength="15" name="like_type" placeholder="请输入喜欢妹子类型" rows="2"><?=$queries['like_type']?></textarea>
                            <div class="weui_textarea_counter"><span>0</span>/15</div>
                        </div>
                    </div>
                </div>
                <div class="weui_cells_title">备注</div>
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_bd weui_cell_primary">
                            <textarea class="weui_textarea" maxlength="100" name="extra" placeholder="其他" rows="3"><?=$queries['extra']?></textarea>
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
            $.get('/collecting-files/delete?id='+id, function (data) {
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
            if (validate_required(weichat,'微信号不可为空')==false)
            {weichat.focus();return false}
            if (validate_required(email,'邮箱不可为空')==false)
            {email.focus();return false}
            if (validate_required(age,'生日为必选内容')==false)
            {age.focus();return false}
            if (validate_required(height,'身高不可为空')==false)
            {height.focus();return false}
            if (validate_required(weight,'体重不可为空')==false)
            {weight.focus();return false}
        }

    }

    $('#submit_text').click(function () {

        if($('#preview img').size()<4){
            $('.notice_content').html('上传图片数量不可小于4张');
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

/*    $(".collecting-files-img").on('click',function(e){
        if(confirm('确定删除吗')) {
            $.get('/collecting-files/delete?id=' + $(this).attr('data-id'), function (data) {
                history.go(0);
            });
        }
    });*/

    $('#preview_weima').on('click',function () {
        if(confirm('确定删除吗')){
            $.get('/collecting-files/delete-weima?id='+$('#preview_weima .preview').attr('data-id'),function (data) {
                history.go(0);
            });
        }
    })
</script>