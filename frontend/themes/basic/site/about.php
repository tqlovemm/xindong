<?php
$this->title = "关于我们";
$this->registerCss('
    .about-title{padding: 30px 10px; background-color: #F1DDE6;text-align: center;}
    .title-china{color:#D94071;font-weight: bold;}
    .title-english{color:#fff;}
    
    .about-up{padding: 30px 10px; background-color: #fff;text-align: center;}
    .about-up h3,.about-up h5,.about-up h6{font-weight: bold;}
    .about-up h6{color:#616161;line-height: 20px;}
    .about-up h3{color:#C64A85;margin-bottom: 20px;}
    
    .about-down{background-color: #fff;}
    
    .about-content{background-color: #F1DDE6;height: 900px;position: relative;}
    .ball{position: absolute;border-radius: 50%;color:#fff;}
    .ball h6{line-height: 20px;}
    .about-content .ball1{background-color: #D84071;width: 400px;height: 400px;top:450px;left: 250px;z-index: 9;padding:100px 50px;}
    .about-content .ball2{background-color: #3C4785;width: 500px;height: 500px;top:350px;left: 500px;z-index: 8;padding:70px 100px;}
    .about-content .ball3{background-color: #DE6BA6;width: 500px;height: 500px;top:30px;left: 200px;z-index: 7;padding:160px 20px;}
    .about-content .ball4{background-color: #fff;width: 400px;height: 400px;top:90px;left: 560px;z-index: 6;padding-top:80px;padding-left: 180px;}
    .ball4 .ball-ball{width: 140px;height: 140px;font-size: 30px;-webkit-border-radius: 50%;-moz-border-radius: 50%;border-radius: 50%;background-color: #D14186;padding:20px 0;text-align: center;}

    .about-content-mobile{background-color: #fff;padding:5px 10px;}
    .mobile-list{border-bottom: 1px solid #ddd;}
    .mobile-list h3{color:#CA4381;font-weight: bold;}
    .mobile-list h5{font-weight: bold;line-height: 20px;}
');
?>
<?php if ($this->beginCache($id=4, ['duration' => 86400])) :?>
<div class="container">
    <div class="row about-title">
        <h2 class="title-china">关于我们</h2>
        <h2 class="title-english">ABOUT US</h2>
    </div>
    <div class="row about-up">
        <h3>全球华人交友寻约平台</h3>
        <h5>十三平台，运营中国最大的在线觅约交友平台</h5>
        <h6>通过互联网，无线平台和线下活动为中国大陆、香港、澳门、台湾以及世界其他国家和地区的优秀人士提供娱乐交友服务</h6>
    </div>
    <div class="row about-down">
        <img class="img-responsive" src="/images/about/world.png">
    </div>

    <!--pc端显示-->
    <div class="row about-content visible-lg visible-md">
        <div class="ball ball1">
            <h4>03 愿景</h4>
            <h6>帮助海内外人士找到幸福伴侣，成为娱乐交友行业的旗帜和标准制定者。</h6>
        </div>
        <div class="ball ball2">
            <h4>02 理念</h4>
            <h6>精准快速的解决每一个优质会员的需求，并将平台口碑作为最终追求。</h6>
        </div>
        <div class="ball ball3">
            <h4>01 定位</h4>
            <h6>13平台服务于真诚寻约的单身人群，并建立严格的身份认证机制和会员投诉机制通过客服人工审核，技术屏蔽以及会员投诉等方式屏蔽不良会员，尽最大努力维护征友会员的质量，征友过程安全.</h6>
        </div>
        <div class="ball ball4">
            <div class="ball-ball">
                <div>会员</div>
                <div>20000+</div>
            </div>
        </div>
    </div>

    <!--移动端显示-->
    <div class="row visible-sm visible-xs about-content-mobile">
        <div class="mobile-list">
            <h3>01 定位</h3>
            <h5>13平台服务于真诚寻约的单身人群，并建立严格的身份认证机制和会员投诉机制通过客服人工审核，技术屏蔽以及会员投诉等方式屏蔽不良会员，尽最大努力维护征友会员的质量，征友过程安全。</h5>
        </div>
        <div class="mobile-list">
            <h3>02 理念</h3>
            <h5>精准快速的解决每一个优质会员的需求，并将平台口碑作为最终追求。</h5>
        </div>
        <div class="mobile-list">
            <h3>03 愿景</h3>
            <h5>帮助海内外人士找到幸福伴侣，成为娱乐交友行业的旗帜和标准制定者。</h5>
        </div>
    </div>
</div>
<?php $this->endCache();endif;?>

