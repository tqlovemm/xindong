<?php

$this->title = "我的参赛信息";
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

if($model->status==1){
    $result='<span style="color:orange;">信息审核中<small>（请耐心等待哦）</small></span>';
}elseif($model->status==2){
    $result = '<span style="color:green;">信息审核通过<small>（邀请好友来投票吧）</small></span>';
}elseif($model->status==3){
    $result = '<span style="color: blue;">信息审核不通过<small>(请重新上图片或者修改信息)</small></span>';
}else{
    $result = '<span style="color:red;">网站内部错误<small>（请联系客服修改）</small></span>';
}

?>
<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
<?php $this->registerJsFile('js/jquery.wallform.js', ['depends' => ['frontend\assets\AppAsset'], 'position' => $this::POS_HEAD]); ?>
<div id="header" class="row" style="padding:10px;background-color: #E73E77;text-align: center;color:#fff;font-size: 20px;font-weight: bold;"><?=$this->title?></div>
<div id="main" class="row" style="padding:10px;background-color: #fbf9fe;">
    <div id="up_status" style="display:none"><img src="/images/loader.gif" alt="uploading"/></div>
    <b>报名结果：<?=$result?></b>
    <div class="demo">
        <form id="imageform" method="post" enctype="multipart/form-data">
            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_bd weui_cell_primary">
                        <div class="weui_uploader">
                            <div class="weui_uploader_hd weui_cell">
                                <div class="weui_cell_bd weui_cell_primary">我的参赛照</div>
                                <div class="weui_cell_ft weui_cell_fts"><span><?=count($imgs)?></span>/6</div>
                            </div>
                            <div class="weui_uploader_bd">
                                <div class="weui_uploader_files" id="preview">
                                    <?php foreach($imgs as $img):?>
                                    <a href="<?=$img['thumb']?>" data-title="d" data-lightbox="d">
                                        <img src="<?=$img['thumb']?>" data-id="<?=$model['id']?>" class="preview collecting-files-img">
                                    </a>
                                    <?php endforeach;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form method="post">

            <div class="form-group">
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label" style="font-size: 13px;">参赛编号</label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" id="weichat-text" type="text" name="number" disabled value="<?=$model['id']?>"  placeholder="参赛编号"/>
                        </div>
                    </div>
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label" style="font-size: 13px;">平台/微博号</label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" id="weichat-text" type="text" name="number" disabled value="<?=$model['plateId']?>"  placeholder="平台编号或微博号"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="weui_cells_title" style="color: #333333;font-weight: bold;font-size: 13px;">性别</div>
            <div class="weui_cells weui_cells_radio">
                <?php if($model['sex']===0):?>
                <label class="weui_cell weui_check_label" for="x13">
                    <div class="weui_cell_bd weui_cell_primary" style="color: grey;font-weight: 200;font-size: 12px;">
                        男生
                    </div>
                    <div class="weui_cell_ft">
                        <input type="radio" name="sex" value="0" class="weui_check" id="x13" style="display: none" checked>
                        <span class="weui_icon_checked"></span>
                    </div>
                </label>
                <?php else:?>
                <label class="weui_cell weui_check_label" for="x11">
                    <div class="weui_cell_bd weui_cell_primary" style="color: grey;font-weight: 200;font-size: 12px;">
                        女生
                    </div>
                    <div class="weui_cell_ft">
                        <input type="radio" class="weui_check" name="sex" value="1" id="x11" style="display: none" checked>
                        <span class="weui_icon_checked"></span>
                    </div>
                </label>
                <?php endif;?>
            </div>
            <div class="weui_cells_title" style="color: #333333;font-weight: bold;font-size: 13px;">交友宣言</div>
            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_bd weui_cell_primary">
                        <div class="weui_textarea"><?=$model['enounce']?></div>
                        <div class="weui_textarea_counter"><span>0</span>/50</div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(function () {

        $('.weui_textarea').siblings('.weui_textarea_counter').children('span').html( $('.weui_textarea').text().length );

    });

</script>
