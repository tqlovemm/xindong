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
?>
<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
<?php $this->registerJsFile('js/jquery.wallform.js', ['depends' => ['frontend\assets\AppAsset'], 'position' => $this::POS_HEAD]); ?>
<script type="text/javascript" src="http://libs.useso.com/js/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.wallform.js"></script>
<div id="header" style="padding:10px;background-color: #F66767;text-align: center;color:#fff;font-size: 20px;font-weight: bold;">我要约会 | 从填表单开始<br>
    【十七高端社交】</div>
<div id="main" style="padding:10px;background-color: #fbf9fe;">

    <b>以下是宝贝们入会时需要填写的个人信息，填写详细真实的宝贝，十七将优先进行审核并推荐优质男生。宝贝们不要心急，慢慢填哦！</b>
    <div class="demo">
        <form id="imageform" method="post" action="/collecting-seventeen-files/upload?type=1">

            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_bd weui_cell_primary">
                        <div class="weui_uploader">

                            <div class="weui_uploader_hd weui_cell" style="padding-bottom: 5px;">
                                <div class="weui_cell_bd weui_cell_primary">微信二维码图片</div>
                                <div class="weui_cell_ft"><span><?=count($img)?></span>/2</div>
                            </div>
                            <div style="color: gray;margin-bottom: 5px;font-size: 13px;">(上传微信二维码名片，方便我们更快更准确的为您服务)</div>
                            <div class="weui_uploader_bd">
                                <div class="weui_uploader_files" id="preview">
                                    <?php
                                        if(!empty($img)):
                                            foreach ($img as $key=>$item):
                                                if($key==2)break;
                                    ?>
                                        <img src="<?=$item['img']?>" data-id="<?=$item['id']?>" class="preview collecting-files-img">
                                    <?php
                                            endforeach;
                                        endif;
                                    ?>
                                </div>
                                <?php if(count($img)<2):?>
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

        <form method="post" action="/collecting-seventeen-files/private-text?id=<?=$queries['id']?>" onsubmit="return validate_form(this);">
            <div class="form-group">
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label">手机号<small style="color:red;">（必填）</small></label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" type="number" name="cellphone" pattern="[0-9]*" placeholder="请输入手机号码"/>
                        </div>
                    </div>
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label">微信号<small style="color:red;">（必填）</small></label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" name="weichat" placeholder="请输入微信号"/>
                        </div>
                    </div>
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label">微博号</label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" name="weibo" placeholder="请输入微博号"/>
                        </div>
                    </div>
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label">Q&nbsp;&nbsp;Q号</label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" type="number" name="qq" pattern="[0-9]*" placeholder="请输入QQ号"/>
                        </div>
                    </div>
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label">身份证号</label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" name="id_number" placeholder="我们帮助买机票和高铁"/>
                        </div>
                    </div>
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label">月资助费</label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" type="number" pattern="[0-9]*" name="pay" placeholder="不懂可不填"/>
                        </div>
                    </div>
                </div>

            </div>
            <div class="weui_cells_tips" style="font-size: 12px;color:#9e9e9e;margin-bottom: 10px;padding:0 5px;">平台现有会员均已经过审核，会员信息严格保密。只为提供真实的、高质量的约会</div>
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

        <div class="weui_dialog_confirm" id="dialog__delete" style="display: none;">
            <div class="weui_mask"></div>
            <div class="weui_dialog">
                <div class="weui_dialog_hd"><strong class="weui_dialog_title">通知</strong></div>
                <div class="weui_dialog_bd">确定删除当前图片信息吗</div>
                <div class="weui_dialog_ft">
                    <a href="javascript:;" class="weui_btn_dialog default iknow">取消</a>
                    <a href="javascript:;" id="delete-img" class="weui_btn_dialog primary" data-id="">确定</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">


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
            if (validate_required(cellphone,'手机号不可为空')==false)
            {cellphone.focus();return false}
            if (validate_required(weichat,'微信号不可为空')==false)
            {weichat.focus();return false}
        }

    }


    $('.iknow').click(function () {

        $('#dialog,#dialog__delete').hide();
    });



/*    $('#submit_text').click(function () {

        if($('#preview img').size()<2){
            $('.notice_content').html('上传图片数量不可小于2张');
            { $('#dialog').show();return false}
        }

    });*/

    $(function () {

        $('.collecting-files-img',this).on('click',function () {
            $('#delete-img').attr('data-id',$(this).attr('data-id'));
            $('#dialog__delete').show();
        });

        $('#delete-img',this).on('click',function () {

            $.get('/collecting-seventeen-files/delete?id='+$(this).attr('data-id'),function (data) {

               history.go(0);
            });

        });


        $('.weui_textarea',this).keyup(function () {

            $(this).siblings('.weui_textarea_counter').children('span').html( $(this).val().length);
        });

        $('#photoimg').die('click').live('change', function(){
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
                    if( $('#preview img').size()>=2 ){
                        btn.hide();
                    }else {
                        btn.show();
                    }

                    $('.weui_cell_ft span').html($('#preview img').size());


                },
                error:function(){
                    status.hide();
                    btn.show();
                } }).submit();
        });
    });

</script>