<?php
$this->title = '联系我们';
$this->params['breadcrumbs'][] = $this->title;
$pre_url = Yii::$app->params['threadimg'];
$this->registerCss('
        .contact-title{padding: 30px 10px; background-color: #F1DDE6;text-align: center;}
        .title-china{color:#D94071;font-weight: bold;}
        .title-english{color:#fff;}
        @media (max-width: 768px) {
            .btn-boy{color: #fff;background-color: #404B8D;border-color: #404B8D;font-size: 24px;font-weight: bold;letter-spacing: 6px;}
            .btn-girl{color: #fff;background-color: #E3326D;border-color: #AC0448;font-size: 24px;font-weight: bold;letter-spacing: 6px;}
            .btn-qq{color: #1EAAE8;background-color: #fff;border-color: ddd;font-size: 24px;font-weight: bold;letter-spacing: 6px;}
            .btn-weibo{color: #000;background-color: #fff;border-color: ddd;font-size: 24px;font-weight: bold;letter-spacing: 6px;}
            .link-to{padding:0 20px;} 
            .link-to hr{ margin-top: 40px;margin-bottom: 40px;border: 0; border-top: 1px solid #D1D1D1;}
            footer{margin-top:0 !important;}
            .lb-data .lb-details{margin-top:10px;color:#fff;}
            .lb-data .lb-number{display:none !important;}
            .lightbox .lb-image{width:280px !important;height:280px !important;}
        }
'); ?>
<?php
/*
$dependency = [
    'class' => 'yii\caching\DbDependency',
    'sql' => 'SELECT MAX(created_at) FROM pre_website_content',
];
if ($this->beginCache($id=25, ['dependency' => $dependency])) :*/?>
<div class="container visible-lg visible-md">

    <div class="row contact-title">
        <h2 class="title-china">联系我们</h2>
        <h2 class="title-english">CONTACT US</h2>
    </div>
    <div class="row"  style="padding: 20px 0;background-color: #3D4886;min-height: 200px;">
        <div class="col-md-3 col-md-offset-2 text-right" style="position: relative;">
            <img style="width: 150px;margin-top: 20px;" src="/images/contact/boy.png">
            <div  style="position: absolute;top:50%;right:0;color:#fff;">扫描二维码加入微信</div>
        </div>
        <div class="col-md-2">
            <img style="width: 170px;" src="<?=$pre_url.$boy[$boy_rand]['path']?>">
        </div>
        <div class="col-md-3">
            <h1 style="font-weight: bold;color:#fff;margin-top: 40px;">男生入口</h1>
            <span style="font-size: 24px;color:#fff;border-radius: 10px;background-color: #163178;padding:0 20px;"><?=$boy[$boy_rand]['name']?></span>
        </div>
    </div>

    <div class="row"  style="padding: 20px 0;background-color: #BF3E67;min-height: 200px;">
        <div class="col-md-3 col-md-offset-2 text-right" style="position: relative;">
            <img style="width: 150px;margin-top: 20px;" src="/images/contact/girl.png">
            <div  style="position: absolute;top:50%;right:0;color:#fff;">扫描二维码加入微信</div>
        </div>
        <div class="col-md-2">
            <img style="width: 170px;" src="<?=$pre_url.$girl[$girl_rand]['path']?>">
        </div>
        <div class="col-md-3">
            <h1 style="font-weight: bold;color:#fff;margin-top: 40px;">女生入口</h1>
            <span style="font-size: 24px;color:#fff;border-radius: 10px;background-color: #A51B4C;padding:0 20px;"><?=$girl[$girl_rand]['name']?></span>
        </div>
    </div>

    <div class="row"  style="padding: 20px 0;background-color: #EFEFEF;min-height: 200px;">
        <div class="col-md-3 col-md-offset-2 text-right" style="position: relative;">
            <img style="width: 150px;margin-top: 20px;" src="/images/contact/two.png">
            <div  style="position: absolute;top:50%;right:0;color:#000;">扫描二维码加入QQ</div>
        </div>
        <div class="col-md-2">
            <img style="width: 170px;" src="/images/contact/qq二维码.jpg">
        </div>
        <div class="col-md-3">
            <br><br>
            <span style="font-size: 24px;color:#fff;border-radius: 10px;background-color: #299CC8;padding:0 20px;margin-top: 40px;">QQ客服</span>
            <h1 style="color:gray;margin-top: 10px;">8495167</h1>
        </div>
    </div>
    <div class="row"  style="padding: 90px 0;background-color: #fff;max-height: 260px;text-align: center;overflow: hidden;background: url(/images/contact/weibopicture.jpg) center;">
        <div class="btn" style="background-color: #fff;">
            <a href="http://weibo.com/13jiaoyoupt">
                <img style="width: 40px;margin-top: -10px;" src="/images/contact/weibo.png">&nbsp;<span style="font-size: 24px;font-weight: bold;color:#D04184;">微博男女互动</span> <span style="font-size: 22px;">点击进入</span>
            </a>
        </div>
    </div>
</div>
<div class="container visible-xs visible-sm" style="padding: 0;background-color: #F1DDE6;min-height: 500px;">

    <h1 class="text-center" style="color:#D94877;font-weight: bold;">联系我们</h1>
    <h1 class="text-center" style="color:#fff;font-weight: bold;font-size: 44px;margin-bottom: 40px;">CONTACT US</h1>

    <div class="link-to">
        <div class="row">
            <div class="center-block" style="width: 300px;">
                <div class="pull-left" style="margin-left: 20px;">
                    <img style="width: 40px;margin-top: 5px;float: right;margin-right: 10px;" class="img-responsive" src="/images/contact/boy.png">
                </div>
                <div class="pull-left">
                    <a data-title="男生入口 <?=$boy[$boy_rand]['name']?>" data-lightbox="dd" href="<?=$pre_url.$boy[$boy_rand]['path']?>" class="btn btn-boy">男生入口&nbsp;&nbsp;<img style="width: 28px;" src="/images/contact/arrow.png"></a>
                </div>
            </div>
        </div>
        <h5 class="row text-center" style="font-size: 14px;">点击进入</h5>
        <hr>
        <div class="row">
            <div class="center-block" style="width: 300px;">
                <div class="pull-left" style="margin-left: 20px;">
                    <img style="width: 40px;margin-top: 5px;float: right;margin-right: 10px;" class="img-responsive" src="/images/contact/girlblack.png">
                </div>
                <div class="pull-left">
                    <a data-title="女生入口 <?=$girl[$girl_rand]['name']?>" data-lightbox="dd" href="<?=$pre_url.$girl[$girl_rand]['path']?>" class="btn btn-girl">女生入口&nbsp;&nbsp;<img style="width: 28px;" src="/images/contact/arrow.png"></a>
                </div>
            </div>
        </div>
        <h5 class="row text-center" style="font-size: 14px;">点击进入</h5>
        <hr>
        <div class="row">

            <div class="center-block" style="width: 300px;">
                <div class="pull-left" style="margin-left: 20px;">
                    <div style=" width: 40px;">&nbsp;</div>
                </div>
                <div class="pull-left btn btn-qq" style="margin-left: -15px;">

                        <img style="width: 28px;" src="/images/contact/qq.png"><a href="http://wpa.qq.com/msgrd?v=3&uin=8495167&site=qq&menu=yes">&nbsp;QQ客服&nbsp;<img style="width: 28px;" src="/images/contact/arrow2.png"></a>
                </div>
            </div>

        </div>
        <h5 class="row text-center" style="font-size: 14px;">点击进入</h5>
<hr>
        <div class="row" style="margin-bottom: 40px;padding:60px 0;;background: url(/images/contact/weiboshoujibackground.jpg) no-repeat;background-size:100% auto;">
            <div class="center-block" style="width: 300px;">
                <div class="pull-left" style="margin-left: 20px;">
                    <div style=" width: 40px;">&nbsp;</div>
                </div>
                <div class="pull-left btn btn-weibo" style="margin-left: -15px;">
                    <a href="http://weibo.com/13jiaoyoupt">
                        <img style="width: 28px;" src="/images/contact/weibo.png">&nbsp;微博互动<img style="width: 28px;" src="/images/contact/arrow2.png">
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>
<?php /*$this->endCache();endif;*/?>
