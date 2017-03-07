<?php
$this->title = "十三平台入会信息核实表";
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
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
<?php $this->registerJsFile('js/jquery.wallform.js', ['depends' => ['frontend\assets\AppAsset'], 'position' => $this::POS_HEAD]); ?>
<div id="header" class="row" style="padding:5px;background-color: #fff;text-align: center;color:#e83f78;font-size: 20px;font-weight: bold;"><?=$this->title?></div>
<div id="main" class="row" style="padding:10px;background-color: #fbf9fe;">
    <b>入会前需要您填写您的相关信息，便于我们联系核实，<span style="color:red;">请务必准确填写！！</span></b>
    <div id="up_status" style="display:none"><img src="/images/loader.gif" alt="uploading"/></div>
    <div class="demo">


        <form method="post" action="check-form" onsubmit="return validate_form(this);">
            <div class="form-group">
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label">联系方式</label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" id="weichat-text" type="text" name="cellphone" value=""  placeholder="微信号或者手机号"/>
                        </div>
                    </div>
                </div>
                <div class="weui_cells_title">选择</div>
                <div class="weui_cells">
                    <div class="weui_cell weui_cell_select weui_select_after">
                        <div class="weui_cell_hd">
                            <label for="" class="weui_label">所在区域</label>
                        </div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <select class="weui_select" name="annual_salary">
                                <option value="">请选择</option>
                                <option value=3>北上广苏浙</option>
                                <option value=1>新蒙青甘藏宁琼</option>
                                <option value=2>包括海外在内的其他地区</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="weui_cells_title">备注</div>
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_bd weui_cell_primary">
                            <textarea class="weui_textarea" maxlength="100" name="extra" placeholder="备注内容" rows="3"></textarea>
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
            if (validate_required(cellphone,'联系方式不可为空')==false)
            {cellphone.focus();return false}
            if (validate_required(annual_salary,'地区为必选项')==false)
            {annual_salary.focus();return false}


        }

    }


    $('.iknow').click(function () {

        $('#dialog,#dialog__delete').hide();
    });


    $(function () {

        $('.collecting-files-img',this).on('click',function () {
            $('#delete-img').attr('data-id',$(this).attr('data-id'));
            $('#dialog__delete').show();
        });

        $('#delete-img',this).on('click',function () {

            $.get('/collecting-files/delete?id='+$(this).attr('data-id'),function (data) {

                history.go(0);
            });

        });


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
    });

</script>