<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
<?php
$session = Yii::$app->session;
if(!$session->isActive){
    $session->open();
}
$this->title = "炫腹季参赛申请表";
$this->registerCss('
    .navbar.navbar-custom ,footer,#izl_rmenu{display:none;}
    .preview{border:solid 1px #dedede;padding:10px;height:75px;width:75px;margin-right: 9px;margin-bottom: 9px;float:left;}
    .btn{position: relative;overflow: hidden;margin-right: 4px;display:inline-block;*display:inline;padding:6px 10px;font-size:14px;line-height:18px;*line-height:20px;color:#fff;text-align:center;vertical-align:middle;cursor:pointer;border:1px solid #cccccc;border-color:#e6e6e6 #e6e6e6 #bfbfbf;border-bottom-color:#b3b3b3;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;}
    .btn input {position: absolute;top: 0; right: 0;margin: 0;border: solid transparent;opacity: 0;filter:alpha(opacity=0); cursor: pointer;}
    #imageform .form-control{margin-bottom:5px;}
    .weui_btn_area{margin:0 !important;}
    .weui_cells_radio p{margin:0;}
    #main label{margin-bottom:0}
    .weui_cells{font-size:12px !important;}
    .weui_check{display:none;}
');
?>
<?php $this->registerJsFile('js/jquery.wallform.js', ['depends' => ['frontend\assets\AppAsset'], 'position' => $this::POS_HEAD]); ?>

<div class="row" style="background-color: #31313e;height: 40px;">
    <a href="javascript:history.go(-1);">
        <img src="/images/weixin/return.png" style="width: 20px;position: absolute;top: 10px;left: 10px;"></a>
    <h2 style="color: #fff;text-align: center;line-height: 40px;margin-top: 0;font-size: 18px;">
        <?=$this->title?>
    </h2>
</div>

<div id="main" class="row" style="padding:10px;background-color: #fbf9fe;">
    <?php
    if($model->status === 0){
        echo "<b style='color: green'>提交表格审核通过就可以参赛啦！！</b>";
    }elseif($model->status === 1){
        echo "<b style='color: orange'>您的信息还在审核中，请不要着急！</b>";
    }elseif($model->status === 2){
        echo "<b style='color: blue'>参赛中！</b>";
    }elseif($model->status==3)
        echo "<b style='color: red;'>报名审核不通过,请修改后重新提交，点击图片可删除重新上传。</b>";
    ?>
    <div id="up_status" style="display:none"><img src="/images/loader.gif" alt="uploading"/></div>
    <div class="demo">
        <form id="imageform" method="post" enctype="multipart/form-data" action="uploader">
            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_bd weui_cell_primary">
                        <div class="weui_uploader">
                            <div class="weui_uploader_hd weui_cell">
                                <div class="weui_cell_bd weui_cell_primary">参赛照上传<small>（单张上传至少3张，第一张作为投票封面照）</small></div>
                                <div class="weui_cell_ft weui_cell_fts"><span><?=count($imgs)?> </span>/6</div>
                            </div>
                            <div class="weui_uploader_bd">
                                <div class="weui_uploader_files" id="preview">

                                    <?php if(!empty($imgs)):
                                            foreach($imgs as $img):?>
                                        <img src="<?=$img['thumb']?>" data-id="<?=$img['id']?>" class="preview collecting-files-img">
                                    <?php      endforeach;endif;?>
                                    <?php if(count($imgs)<6):?>
                                        <div class="weui_uploader_input_wrp btn" id="up_btn">
                                            <input class="weui_uploader_input" type="file" id="photoimg" name="photoimg" accept="image/*" multiple />
                                        </div>
                                    <?php endif;?>
                                    <input type="hidden" value="<?=$model->id?>" name="id">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
        <form method="post" action="join-info?id=<?=$session->get('id')?>" onsubmit="return validate_form(this);">
            <div class="form-group">
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label">编号<small>（选填）</small></label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" id="weichat-text" type="text" name="number" value=""  placeholder="平台编号或微博号"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="weui_cells_title" style="font-size: 12px;font-weight: bold;color:#333333">性别</div>
            <div class="weui_cells weui_cells_radio">
                <label class="weui_cell weui_check_label" for="x13">
                    <div class="weui_cell_bd weui_cell_primary" style="font-size: 12px;font-weight: 200;color:grey">
                        男生
                    </div>
                    <div class="weui_cell_ft">
                        <input type="radio" name="sex" value="0" class="weui_check" id="x13" checked>
                        <span class="weui_icon_checked"></span>
                    </div>
                </label>
                <label class="weui_cell weui_check_label" for="x11">
                    <div class="weui_cell_bd weui_cell_primary" style="font-size: 12px;font-weight: 200;color:grey">
                        女生
                    </div>
                    <div class="weui_cell_ft">
                        <input type="radio" class="weui_check" name="sex" value="1" id="x11">
                        <span class="weui_icon_checked"></span>
                    </div>
                </label>
            </div>
            <div class="weui_cells_title" style="font-size: 12px;font-weight: bold;color:#333333">交友宣言</div>
            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_bd weui_cell_primary">
                        <textarea class="weui_textarea" maxlength="50" name="declaration" placeholder="请输入交友宣言" rows="3"></textarea>
                        <div class="weui_textarea_counter"><span>0</span>/50</div>
                    </div>
                </div>
            </div><br>
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
            if (validate_required(declaration,'交友宣言不可为空')==false)
            {declaration.focus();return false}
        }

    }


    $('.iknow').click(function () {

        $('#dialog,#dialog__delete').hide();
    });



    $('#submit_text').click(function () {

        if($('#preview img').size()<1){
            $('.notice_content').html('上传图片数量不可小于1张');
            { $('#dialog').show();return false}
        }

    });

    $(function () {

        $('.collecting-files-img',this).on('click',function () {
            $('#delete-img').attr('data-id',$(this).attr('data-id'));
            $('#dialog__delete').show();
        });

        $('#delete-img',this).on('click',function () {

            $.get('delete-img?id='+$(this).attr('data-id'),function (data) {

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