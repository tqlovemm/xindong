<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
<?php
$this->title = "骗子&红包婊打击行动"; //echo "<pre>";var_dump($model);
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
');
$pre_url = Yii::$app->params['threadimg'];
?>
<?php $this->registerJsFile('js/jquery.wallform.js', ['depends' => ['frontend\assets\AppAsset'], 'position' => $this::POS_HEAD]); ?>
<div class="row" style="background-color: #31313e;height: 40px;">
    <a href="javascript:history.go(-1);">
        <img src="/images/weixin/return.png" style="width: 20px;position: absolute;top: 10px;left: 10px;"></a>
    <h2 style="color: #fff;text-align: center;line-height: 40px;margin-top: 0;font-size: 18px;">
        <?=$this->title?>
    </h2>
    <a style="position: absolute;right:10px;top:10px;color:#fff;"></a>
</div>
<div id="main" class="row" style="padding:10px;background-color: #fbf9fe;">
    <div id="up_status" style="display:none"><img src="/images/loader.gif" alt="uploading"/></div>
    <div class="demo">
        <form id="imageform" method="post" enctype="multipart/form-data" action="uploader?id=<?=$model->tid?>">
            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_bd weui_cell_primary">
                        <div class="weui_uploader">
                            <div class="weui_uploader_hd weui_cell">
                                <div class="weui_cell_bd weui_cell_primary">爆料图片<small>（单张上传）</small></div>
                                <div class="weui_cell_ft weui_cell_fts"><span><?=count($img)?></span>/9</div>
                            </div>
                            <div class="weui_uploader_bd">
                                <div class="weui_uploader_files" id="preview">
                                    <?php
                                    if(!empty($img)):
                                        foreach ($img as $item):
                                            ?>
                                            <img onclick="delete_img(<?=$item['id']?>)" src="<?=$pre_url.$item['thumbimg']?>" data-id="<?=$item['id']?>" class="preview collecting-files-img">
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
                                <?php if(count($img)<9):?>
                                    <div class="weui_uploader_input_wrp btn" id="up_btn">
                                        <input class="weui_uploader_input" type="file" id="threadimg" name="threadimg" accept="image/*" multiple />
                                    </div>
                                <?php endif;?>
                                <input type="hidden" value="<?=$model->tid?>" name="id">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form method="post" action="save-info?id=<?=$model->tid?>" onsubmit="return validate_form(this);">
            <div class="weui_cells_title" style="font-weight: bold;color: black">我来爆料</div>
            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_bd weui_cell_primary">
                        <textarea class="weui_textarea" maxlength="512" name="declaration" placeholder="爆料内容" rows="8"></textarea>
                        <div class="weui_textarea_counter"><span>0</span>/512</div>
                    </div>
                </div>
            </div><br>
            <div class="weui_btn_area">
                <input class="weui_btn weui_btn_primary" id="submit_text" type="submit" value="确认提交">
            </div>
        </form>
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

    function delete_img(id){

        if(confirm('确认删除')){
            $.get('delete-img?id='+id, function (data) {
                history.go(0);
            });
        }

    }


    $(function () {

        $('.weui_textarea',this).keyup(function () {

            $(this).siblings('.weui_textarea_counter').children('span').html( $(this).val().length);
        });

        $('#threadimg').on('change', function(){
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
                    if( $('#preview img').size()>=9 ){
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