<?php
use yii\web\View;
$this->registerCss("
    .navbar,footer,.weibo-share{display:none;}
    .lb-nav{z-index:10 !important;}
    .lb-nav a.lb-next,.lb-nav a.lb-prev{opacity:1;}
    .weui_cells p{margin-bottom:0;color:#888;}
    .weui_cell_primary .col-xs-4{padding:0;}
    .weui_cell_primary .col-xs-4 span{color: #888;margin-left:1px;}
    .weui_cell_ft{color:#000 !important;}
    body {font-family: '微软雅黑' !important; }
    .weui_uploader_bd,.weui_cell_ft,.weui_cell_bd{font-size:16px;}
    .weui_cells{margin-top:10px !important;}
    .weui_cell .col-xs-4{font-size:16px;padding:0;}
    
    .focus{ width:100%; height:inherit;  margin:0 auto; position:relative; overflow:hidden;   }
    .focus .hd{ width:100%; height:11px;  position:absolute; z-index:9; bottom:5px; text-align:center;  }
    .focus .hd ul{ display:inline-block; height:10px; padding:0 5px; background-color:rgba(255,255,255,0.7);
        -webkit-border-radius:5px; -moz-border-radius:5px; border-radius:5px; font-size:0; vertical-align:top;
    }
    .focus .hd ul li{ display:inline-block; width:10px; height:10px; -webkit-border-radius:5px; -moz-border-radius:5px; border-radius:5px; background:#8C8C8C; margin:0 5px;  vertical-align:top; overflow:hidden;   }
    .focus .hd ul .on{ background:#FE6C9C;  }
    .focus .bd{ position:relative; z-index:8; }
    .focus .bd li img{ max-width:100%;  height:inherit;}
    .focus .bd li a{ -webkit-tap-highlight-color:rgba(0, 0, 0, 0);}
    .focus .bd .col-md-4{padding:0 5px;}
    .weui_uploader_file{width:69px !important;height:69px !important;}
    
    
");
$this->title = "男生档案详情";
$this->registerJsFile(Yii::getAlias('@web')."/js/TouchSlide.1.1.source.js",['position' => View::POS_HEAD]);
$pre_url = Yii::$app->params['imagetqlmm'];
?>
<meta name="x5-fullscreen" content="true">
<meta name="full-screen" content="yes">
<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
<div id="show-img" style="position: absolute;width: 100%;height: 100%;background-color: rgba(5, 5, 5, 0.78);z-index: 8;padding: 40px 10px;top:0;">
    <div class="" style="width: 100%;height: 100%;background-color: #fff;padding-top: 4px;border-radius: 5px;overflow: hidden;position: relative;border:1px solid #fff;">
        <span id="close" style="position: absolute;right:0;top:-15px;font-size: 30px;z-index: 999;padding:10px;">&times;</span>
        <div id="focus" class="focus">
            <div class="hd">
                <ul></ul>
            </div>
            <div class="bd" style="padding-top: 15px;">
                <ul>
                    <?php foreach ($imgs as $img):?>
                        <li>
                            <img class="img-responsive center-block" src="<?=$pre_url.$img->thumb_img?>">
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('body').css({'overflow':'hidden'});
        $('#show-img').bind("touchmove",function(e){
            e.preventDefault();
        });

        $("#close").on('click',function () {

            $('#show-img').fadeOut('slow',function () {
                $('body').css({'overflow':'auto'});
            });

        });


        $('.weui_uploader_file').click(function () {

            $('#show-img').fadeIn('slow',function () {
                $('body').css({'overflow':'hidden'});
            });

        })

    });

</script>
<div class="bd">
    <div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_bd weui_cell_primary">
                <div class="weui_uploader">
                    <div class="weui_uploader_hd weui_cell">
                        <div class="weui_cell_bd weui_cell_primary" style="color:#000;font-size: 15px;font-weight: 600;">档案照 <small style="color: gray;">(点击可放大)</small></div>
                    </div>
                    <div class="weui_uploader_bd">
                        <ul class="weui_uploader_files">
                            <?php foreach ($imgs as $key=>$img):
                                if($key>=4)
                                    break;
                                ?>
                                <li class="weui_uploader_file" style="background-image:url(<?=$pre_url.$img->thumb_img?>)"></li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="weui_cells">
        <div class="row" style="margin: 0;background-color: #fff;padding:10px 0;">
            <div class="col-xs-5" style="background-image: url('/images/collecting-files/517865065565295460.png');background-size:cover;background-repeat: no-repeat;padding:8px 20px;text-align: center;color:#fff;border-bottom-right-radius: 5px;border-top-right-radius: 5px;">
                编号：<?=$model->id?>
            </div>
            <div class="col-xs-offset-1 col-xs-6" style="border-left: 1px solid #ddd;font-size: 12px;">
                <img style="width: 54px;" src="/images/collecting-files/comments.png">
            </div>
        </div>
    </div>
    <div class="weui_cells">
        <div class="weui_cell">
            <div class="weui_cell_bd">
                <p>地区：</p>
            </div>
            <div class="weui_cell_ft"><?=$model->address?></div>
        </div>
        <?php if(!empty($model->car_type)):?>
            <div class="weui_cell">
                <div class="weui_cell_bd">
                    <p>车型：</p>
                </div>
                <div class="weui_cell_ft"><?=$model->car_type?></div>
            </div>
        <?php endif;?>
        <div class="weui_cell">
            <div class="col-xs-4">年龄:<?=floor((time()-$model->age)/(86400*365))?> 岁</div>
            <div class="col-xs-4">身高:<?=$model->height?> cm</div>
            <div class="col-xs-4">体重:<?=$model->weight?> kg</div>
        </div>
    </div>
    <div class="weui_cells">
        <div class="weui_cell">
            <div class="weui_cell_bd">
                <p>职业：</p>
            </div>
            <div class="weui_cell_ft"><?=$model->job?></div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_bd">
                <p>年薪：</p>
            </div>
            <div class="weui_cell_ft"><?=$model->annual_salary?></div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_bd">
                <p>兴趣爱好：</p>
            </div>
            <div class="weui_cell_ft"><?=$model->hobby?></div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_bd">
                <p>喜欢类型：</p>
            </div>
            <div class="weui_cell_ft"><?=$model->like_type?></div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_bd">
                <p>经常出没：</p>
            </div>
            <div class="weui_cell_ft"><?=$model->often_go?></div>
        </div>
    </div>
    <div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_bd weui_cell_primary">
                <div class="weui_uploader">
                    <div class="weui_uploader_hd weui_cell">
                        <p class="weui_cell_bd weui_cell_primary">简介：</p>
                    </div>
                    <div class="weui_uploader_bd">
                        <?=$model->extra?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    TouchSlide({
        slideCell:"#focus",
        titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
        mainCell:".bd ul",
        effect:"left",
        interTime:5000,
        autoPlay:true,//自动播放
        autoPage:true, //自动分页
        switchLoad:"_src" //切换加载，真实图片路径为"_src"
    });
</script>