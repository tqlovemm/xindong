<?php

use yii\web\View;

$this->title = Yii::$app->setting->get('siteTitle');

$this->registerCss('

.carousel-inner .item{width: 100%;height: 100%;}
.navbar-fixed-top{background-color: white;}
.focus{ width:100%; margin:0 auto; position:relative; overflow:hidden;   }
.focus .hd{ width:100%; height:5px;  position:absolute; z-index:1; bottom:0; text-align:center;  }
.focus .hd ul{ overflow:hidden; display:-moz-box; display:-webkit-box; display:box; height:5px; background-color:rgba(51,51,51,0.5); padding:0;  }
.focus .hd ul li{ -moz-box-flex:1; -webkit-box-flex:1; box-flex:1; }
.focus .hd ul .on{ background:#FF4000;}
.bar-active{color: rgba(239, 68, 80, 1);background:none;}
.focus .bd{ position:relative; z-index:0; }
.focus .bd li{width: 100%;height: 100%;text-align: center;overflow: hidden;}
//.focus .bd li img{width: 100%;height: 100%;}
.focus .bd li a{ -webkit-tap-highlight-color:rgba(0, 0, 0, 0); /* 取消链接高亮 */ }
.bd li{list-style: none;}
.navbar-fixed-bottom .navbar-collapse, .navbar-fixed-top .navbar-collapse{min-height: 3.5em !important;}


.home-img{width: 100%;height: 780px;background-position: center;background-repeat: no-repeat;}

@media (max-width:768px ) {

    .home-img{width: 100%;height: 500px;background-size: cover;}
}

');
?>
<?php $this->registerJsFile("@web/js/TouchSlide.1.1.source.js",['position' => View::POS_HEAD]);if($wx_validate==true):?>
<div class="gd_zz_sy" style="width: 100%;height: 100%;background-color: rgba(149, 149, 149, 0.79);position: fixed;top:0;display: none;z-index: 98999999;">
    <div class="center-block sy_card" style="width: 90%;display: none;padding:0 8px 8px 8px;background-color: #f4f3f9;position: relative;top:50%;margin-top: -200px;border-radius: 10px;">
        <span id="close_sy" style="font-size: 22px;color:#a0a0a0;">&times;</span>
        <h5 class="text-center" style="line-height: 20px;text-align: left;">微信认证并且关注十三平台微信公众号（心动三十一天）轻松获取女生二维码</h5>
        <div class="text-center"><a class="btn btn-success" href="/weixin/firefighters/index-test">去认证</a></div>
        <div class="" style="padding:15px 10px 10px;"><img class="img-responsive" src="/images/weixin/3.jpg"></div>
    </div>
</div>
<script>
    if($(window).width()<500){
        setTimeout(function () {
            $('.gd_zz_sy').fadeIn(200,function () {
                $('.sy_card').slideDown(1000);
            });
            $('#close_sy').on('click',function () {
                $('.sy_card').slideUp(1000,function () {
                    $('.gd_zz_sy').fadeOut(200);
                });
            });
        },1000);
    }
</script>
<?php endif;?>
<?php if ($this->beginCache($id=2016, ['duration' => 86400])) :?>
<div class="home">
        <div id="focus" class="focus visible-md visible-lg">
            <div class="hd">
                <ul></ul>
            </div>
            <div class="bd">
                <ul>
                    <li>
                        <img class="img-responsive" src="<?= Yii::getAlias('@web')?>/images/home/slide_01.jpg">
                    </li>
                    <li>
                        <img class="img-responsive" src="<?= Yii::getAlias('@web')?>/images/home/shian-3pc.jpg">
                    </li>
                </ul>
            </div>
        </div>
        <div id="focus2" class="focus visible-sm visible-xs">
            <div class="hd">
                <ul></ul>
            </div>
            <div class="bd">
                <ul>
                    <li>
                        <a href="http://www.13loveme.com/heart-slide/19">

                            <img class="img-responsive" src="<?= Yii::getAlias('@web')?>/images/index/464021723025016472.jpg">
                        </a>

                    </li>
                    <li>
                        <a href="http://www.13loveme.com/heart-slide/21">
                            <img class="img-responsive" src="<?= Yii::getAlias('@web')?>/images/index/790981646511215177.jpg">
                        </a>
                    </li>
                    <li>
                        <a href="http://www.13loveme.com/date-today">
                            <img class="img-responsive" src="<?= Yii::getAlias('@web')?>/images/index/3.jpg">
                            <!--<div class="home-img" style="background-image: url('<?/*= Yii::getAlias('@web')*/?>/images/index/3.jpg');"></div>-->
                        </a>
                    </li>
                    <li>
                        <a href="http://13loveme.com/test/check-service/index">
                            <img class="img-responsive" src="<?= Yii::getAlias('@web')?>/images/index/404057364111307947.png">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <script type="text/javascript">
            TouchSlide({
                slideCell:"#focus",
                titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
                mainCell:".bd ul",
                effect:"leftLoop",
                autoPlay:true,//自动播放
                autoPage:true //自动分页
            });
            TouchSlide({
                slideCell:"#focus2",
                titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
                mainCell:".bd ul",
                effect:"leftLoop",
                autoPlay:true,//自动播放
                autoPage:true //自动分页
            });
        </script>
    </div>
<?php $this->endCache();endif;?>




