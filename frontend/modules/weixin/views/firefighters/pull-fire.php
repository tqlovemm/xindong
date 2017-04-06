<?php
$this->title = "救火";
$this->registerCss("

         nav,footer{display:none;}
        ol li{margin-bottom:15px;}
        .dating__signup{cursor: pointer;}
        .row{margin:0;}
        .hear-img{margin: 10px 6px;}
        div
        #weima img{
        transition: all 1s;
        -moz-transition: all 1s;	/* Firefox 4 */
        -webkit-transition: all 1s;	/* Safari 和 Chrome */
        -o-transition: all 1s;	/* Opera */
        }
        ");

$pre_url = Yii::$app->params['shisangirl'];
?>
<style>
    .middle-img {
        position: absolute;
        left: 259px;
        top: 0px;
        width: 40px;
    }

    .up-img {
        position: absolute;
        top: -40px;
        left: 261px;
        width: 40px;
    }

    .down-img {
        position: absolute;
        top: 40px;
        left: 257px;
        width: 40px;
    }

    .left-img {
        position: absolute;
        left: 218px;
        width: 40px;
    }

    .right-img {
        position: absolute;
        left: 300px;
        width: 40px;
    }
    @media screen and (max-width:450px) {
        .middle-img {
            position: absolute;
            left: 259px;
            top: 0px;
            width: 40px;
            display: none;
        }

        .up-img {
            position: absolute;
            top: -40px;
            left: 261px;
            width: 40px;
            display: none;
        }

        .down-img {
            position: absolute;
            top: 40px;
            left: 257px;
            width: 40px;
            display: none;
        }

        .left-img {
            position: absolute;
            left: 218px;
            width: 40px;
            display: none;
        }

        .right-img {
            position: absolute;
            left: 300px;
            width: 40px;
            display: none;
        }

        .rotate_jia{
            display: none;
        }.rotate_div{
             display: none;
         }.rotate_jian{
              display: none;
          }
    }
</style>
<link id="skin" rel="stylesheet" type="text/css" media="screen" href="/css/auto/style.css" />
<link rel="stylesheet" href="/css/auto/amazeui.min.css" />
<script src="/js/datejs/amazeui.js"></script>

<div id="weima" style="position: absolute;top:0;left:0;z-index: 1;width: 100%;height: 100%;background-color: rgba(125, 125, 125, 0.62);">
    <img style="width: 90%;border: 1px solid #ddd;border-radius: 4px;" class="center-block" src="<?=$pre_url.$file?>">
</div>
<?php

    $this->registerJs("
    
        $('#weima').on('click',function(){
            $('#weima').fadeOut('slow');
        });
        var height = ($('#weima').height()-$('#weima img').height())/2
        $('#weima img').css('margin-top',height);
        
    ");
?>
<section id="slider_wrapper" style="background-color: #fff;">
    <div id="slider" class="divas-slider" style="padding: 10px 0;background-color: #fff;">
        <div class="divas-slide-container" data-am-widget="gallery" data-am-gallery="{ pureview: true }">

                <a href="<?=$pre_url.$contents['pic_path']?>" class="divas-slide am-gallery-item">
                    <img style="width: 70px;height: 70px;margin: 5px 5px 0 0;" src="<?=$pre_url.$contents['pic_path']?>" data-src="<?=$pre_url.$contents['pic_path']?>"/>
                </a>

        </div>
        <div class="divas-navigation visible-lg">
            <span class="divas-prev">&nbsp;</span>
            <span class="divas-next">&nbsp;</span>
        </div>

        <div class="divas-controls visible-md">
            <span class="divas-start"><i class="fa fa-play"></i></span>
            <span class="divas-stop"><i class="fa fa-pause"></i></span>
        </div>
    </div>
</section>
<div class="row" style="margin-top: 10px;">
    <div class="col-xs-6" style="padding-left: 5px;padding-right: 5px;">
        <div class="row liaotianjietu" style="background-color: #fff;padding:10px 0;border-radius: 5px;box-shadow: 0 0 5px #ff8a7e;">
            <div class="col-xs-4" style="padding:0 5px;">
                <img style="width: 50px;" src="/images/dating/jietu.png">
            </div>
            <a href="<?=$pre_url.$file?>" data-title="<?=$remark?>" data-lightbox="s" class="col-xs-8">
                <h6 style="margin-top: 5px;font-weight: bold;color: #E83F78;">快点我哦</h6>
                <h5 style="margin-bottom: 0;font-weight: bold;">女生二维码</h5>
            </a>
        </div>
    </div>
</div>
<div class="row" style="margin-top: 10px;">
    <div class="col-xs-12" style="padding:0 5px;">
        <div class="row" style="background-color: #fff;padding:10px 0;border-radius: 5px;">
            <div class="col-xs-12" style="padding:0 10px;">
                <?php if(!empty($contents['content'])):?>
                    <?=$contents['city']?> <?=$contents['content']?>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
