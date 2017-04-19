<?php
$this->title = "十三平台入会信息";
$this->registerCss('
    .navbar.navbar-custom ,footer,#izl_rmenu{display:none;}
    .preview{border:solid 1px #dedede;padding:10px;height:75px;width:75px;margin-right: 9px;margin-bottom: 9px;float:left;}
    .btn{position: relative;overflow: hidden;margin-right: 4px;display:inline-block;*display:inline;padding:6px 10px;font-size:14px;line-height:18px;*line-height:20px;color:#fff;text-align:center;vertical-align:middle;cursor:pointer;border:1px solid #cccccc;border-color:#e6e6e6 #e6e6e6 #bfbfbf;border-bottom-color:#b3b3b3;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;}
    .btn input {position: absolute;top: 0; right: 0;margin: 0;border: solid transparent;opacity: 0;filter:alpha(opacity=0); cursor: pointer;}
    #imageform .form-control{margin-bottom:5px;}
    .weui_btn_area{margin:0 !important;}
    .weui_cells_radio p{margin:0;}
    #main label{margin-bottom:0}
');
$pre_url = Yii::$app->params['imagetqlmm'];
?>
<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
<?php $this->registerJsFile('js/jquery.wallform.js', ['depends' => ['frontend\assets\AppAsset'], 'position' => $this::POS_HEAD]); ?>
<script type="text/javascript" src="http://libs.useso.com/js/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.wallform.js"></script>
<div id="header" style="padding:10px;background-color: #2695D0;text-align: center;color:#fff;font-size: 20px;font-weight: bold;position: relative;">
    <?=$this->title?>
    <a onclick="change_file()" style="position: absolute;top:0;right:10px;line-height: 52px;color:#fff;font-size: 12px;">
        <span class="glyphicon glyphicon-pencil"></span> <span>修改</span>
    </a>
</div>
<div id="main" style="padding:10px;background-color: #fbf9fe;">

    <b>以下是您入会时填写的个人信息，此页面只有您能打开，链接千万不要分享给别人哦，如果需要修改请联系客服。</b>
    <div class="demo">
        <div class="weui_cells weui_cells_form">
            <div class="weui_cell">
                <div class="weui_cell_bd weui_cell_primary">
                    <div class="weui_uploader">
                        <div class="weui_uploader_hd weui_cell">
                            <div class="weui_cell_bd weui_cell_primary">档案照点击可放大</div>
                            <div class="weui_cell_ft"><span><?=count($img)?></span>/6</div>
                        </div>
                        <div class="weui_uploader_bd">
                            <div class="weui_uploader_files" id="preview">
                                <?php if(!empty($img)):  foreach ($img as $item):?>
                                <a data-lightbox="0" data-title="0" href="<?=$pre_url.$item['img']?>">
                                    <img src="<?=$pre_url.$item['img']?>" data-id="<?=$item['id']?>" class="preview collecting-files-img">
                                </a>
                                <?php endforeach; endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_hd"><label class="weui_label">会员编号</label></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" type="text" disabled value="<?=$queries['id']?>"/>
                    </div>
                </div>
                <div class="weui_cell">
                    <div class="weui_cell_hd"><label class="weui_label">微信号</label></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" id="weichat-text" type="text" name="weichat" disabled value="<?=$queries['weichat']?>"/>
                    </div>
                </div>
                <div class="weui_cell">
                    <div class="weui_cell_hd"><label class="weui_label">微博号</label></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" type="text" name="weibo"  disabled value="<?=$queries['weibo']?>"/>
                    </div>
                </div>

                <div class="weui_cell">
                    <div class="weui_cell_hd"><label class="weui_label">手机号</label></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" type="text" name="weibo" disabled value="<?=$queries['cellphone']?>"/>
                    </div>
                </div>
            </div>

            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_hd"><label class="weui_label">年龄</label></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" disabled value="<?=floor((time()-$queries['age'])/(86400*365))?> 岁"/>
                    </div>
                </div>
                <div class="weui_cell">
                    <div class="weui_cell_hd"><label class="weui_label">身高</label></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" disabled value="<?=$queries['height']?> cm"/>
                    </div>
                </div>
                <div class="weui_cell">
                    <div class="weui_cell_hd"><label class="weui_label">体重</label></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" disabled value="<?=$queries['weight']?> kg"/>
                    </div>
                </div>
            </div>

            <div class="weui_cells_title">婚姻/对象情况</div>
            <div class="weui_cells weui_cells_radio">
                <?php if($queries['marry']==0):?>
                    <label class="weui_cell weui_check_label" for="x13">
                        <div class="weui_cell_bd weui_cell_primary">
                            <p>单身</p>
                        </div>
                        <div class="weui_cell_ft">
                            <input type="radio" name="marry" value="0" disabled class="weui_check" id="x13" checked="checked">
                            <span class="weui_icon_checked"></span>
                        </div>
                    </label>
                <?php elseif ($queries['marry']==1):?>
                    <label class="weui_cell weui_check_label" for="x12">
                        <div class="weui_cell_bd weui_cell_primary">
                            <p>有女友</p>
                        </div>
                        <div class="weui_cell_ft">
                            <input type="radio" name="marry" value="1" disabled class="weui_check" id="x12" checked="checked">
                            <span class="weui_icon_checked"></span>
                        </div>
                    </label>
                <?php else:?>
                    <label class="weui_cell weui_check_label" for="x11">
                        <div class="weui_cell_bd weui_cell_primary">
                            <p>已婚</p>
                        </div>
                        <div class="weui_cell_ft">
                            <input type="radio" class="weui_check" disabled name="marry" value="2" id="x11" checked="checked">
                            <span class="weui_icon_checked"></span>
                        </div>
                    </label>
                <?php endif;?>
            </div>

            <div class="weui_cells_title">职位</div>
            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_bd weui_cell_primary">
                        <p class="weui_textarea">
                            <?=$queries['job']?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="weui_cells_title">兴趣爱好</div>
            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_bd weui_cell_primary">
                        <p class="weui_textarea">
                            <?=$queries['hobby']?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="weui_cells_title">喜欢妹子类型</div>
            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_bd weui_cell_primary">
                        <p class="weui_textarea">
                            <?=$queries['like_type']?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="weui_cells_title">备注</div>
            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_bd weui_cell_primary">
                        <p class="weui_textarea">
                            <?=$queries['extra']?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function change_file(){

        if(confirm('确定修改资料吗？需要扣除30节操币!')){

            window.location.href = "/collecting-files/change-file";
        }

    }
</script>