<?php

$cookie = Yii::$app->request->cookies;
\frontend\assets\AutoAsset::register($this);

$this->title = "会员入会";
$this->registerCss("
      .navbar{display:none;}
      footer{display:none;}
      .sangar-slideshow-container div.sangar-timer{display: none !important;}
      .sangar-slideshow-container .sangar-position-sticky-bottom > .sangar-textbox-content{padding-bottom:0;}
      .aj_member_sort_icon{}
      .aj_member_sort_icon img{width:35px;}
      .nav-tabs > li{float:none;}
      .auto-member-name{padding:0;line-height:103px;color:#aaa;border-right: 1px solid #eee;}
      .auto-member-name img{width:35px;}
      .auto-member-price{padding:0;text-align:center;}
      .auto-member-price h3{margin: 0;color:gray;}
      .auto-member-price h5{margin: 8px 0;}
      .auto-member-price h5 span{color:gray;}
      .auto-member-choice{line-height:103px;padding:0;text-align:right;}
      .nav > li > a{padding:10px;color:#aaa;}
      .nav-tabs > li > a{margin-right:0;border:none;}
      .area__choice{font-size: 12px;background-color: #fff;border:1px solid #eee;outline: none;padding:3px 0;border-radius: 4px;width: 130px;}
      .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus{color: #555;cursor: default;background-color: transparent;border: none;border-bottom-color: transparent;}
      .auto-member-name .in-icon1{display:inline-block;width:35px;height:35px;background-image:url('/images/auto/gaoduan2.png');background-size:cover;margin-right:10px;}
      .auto-member-name .in-icon2{display:inline-block;width:35px;height:35px;background-image:url('/images/auto/putong2.png');background-size:cover;margin-right:10px;}
      .auto-member-name .in-icon3{display:inline-block;width:35px;height:35px;background-image:url('/images/auto/zhizun2.png');background-size:cover;margin-right:10px;}
      li.active .auto-member-name{color:gray;}
      li.active .auto-member-name .in-icon1{background-image:url('/images/auto/gaoduan.png');}
      li.active .auto-member-name .in-icon2{background-image:url('/images/auto/putong.png');}
      li.active .auto-member-name .in-icon3{background-image:url('/images/auto/zhizun.png');}
      li.active .auto-member-price h3{color:#E04178;}
      li.active .auto-member-price h5 span{color:#E04178;}
      .nav-tabs li{border-bottom:1px solid #eee;}
      .open-member{position: fixed;bottom:0;text-align: center;padding:10px;background-color: #14161B;color:#E3AD0C;width: 100%;font-size: 20px;font-weight: bold;}
      .auto-member-choice span.in-con1{display:inline-block;width:16px;height:16px;background-image:url('/images/auto/yes2.png');background-size:cover;margin-right:10px;}
      li.active .auto-member-choice span.in-con1{background-image:url('/images/auto/yes.png');}
      .tab-pane{padding:10px 0;}
      .tab-pane .col-xs-6{text-align:center;border-top:1px solid #eee;}
      .xs6{border-right:1px solid #eee;}
      .col-xs-6 h5{color:gray;font-weight:bold;}
      .col-xs-6 h6{color:#E04178;font-weight:bold;}
      .col-xs-6{position:relative;padding:10px 10px;}
      .col-xs-6 .mark{position: absolute;top:0;left:5px;background-color:#fff;font-size:14px;font-weight:bold;}
      label{margin-bottom:0;}
      .membership-pay{position: fixed;bottom:0;background-color: rgba(142, 142, 142, 0.46);height: 100%;width: 100%;z-index: 9;display: none;}
      .membership-box{height: 370px;position: absolute;bottom: 0;width: 100%;background-color: #fff;}
      #box__close{width: 20px;height:20px;position: absolute;top:-18px;right: 0;background-color: #fff;border-radius: 3px;font-weight: bold;text-align: center;line-height: 20px;}
      .auto-join-member li{margin-bottom:5px;background-color:#fff;}
      .membership_sort_ch{position: relative;border-bottom: 1px solid #eee !important;}
      .btn-slide{color:#aaa !important;}
      li.active .btn-slide{color:#E04178 !important;}
      #pay_submits{display: block;width: 50%;margin: 0 auto;background-color: transparent;text-align: center;padding:5px;font-size: 20px;border: 1px solid #D3B267;color:#D3B267;border-radius: 20px;}

        .server_run_area{width:20px;height:30px;display: inline-block;background-image: url(\"/images/auto/b169be1feeb2.jpg\");}
        .server_run_area.icon1{background-position: 383px 152px;}
        .server_run_area.icon2{background-position: 36px 633px;}
        .server_run_area.icon3{background-position: 583px 354px;}
        .server_run_area.icon4{background-position: 383px 73px;}
        .server_run_area.icon5{background-position: 424px 112px;}
        .server_run_area.icon6{background-position: 424px 234px;}
        .server_run_area.icon7{background-position: 542px 192px;}
        .server_run_area.icon8{background-position: 583px 276px;}
        .server_run_area.icon9{background-position: 301px 396px;}
        .server_run_area.icon10{background-position: 423px 396px;}
        .membership-type-icon{ float: left; }
       
");
?>
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" href="/css/auto/sangarSlider.css" type="text/css" media="all">
<link rel="stylesheet" href="/css/auto/default.css" type="text/css" media="all">

<script>
    function submit_pay(){

        if(confirm('确认开通会员吗？')){
            if($('input[name=cellphone]').val()==''){
                confirm('请输入手机号码');
                $('input[name=cellphone]').css('border-color','red');
                $('input[name=cellphone]').focus();
                return false;
            }
            window.location.href='/member/user/auto-join-pay?data='+
                $('input[type=hidden][name=member_sort]').val()+','+
                $('input[type=hidden][name=member_area]').val()+','+
                $('input[type=hidden][name=recharge_type]').val()+','+
                $('input[name=pay_type]:checked').val()+','+
                $('input[type=hidden][name=cellphone]').val()+','+<?php echo $cookie->getValue('auto_join_13pt')?>;
        }
        return false;
    }

    $('.membership-pay').bind("touchmove",function(e){
        e.preventDefault();
    });

</script>
<div class='sangar-slideshow-container' id='sangar-example' style="padding:5px 0 0;min-height: 195px;">
    <div class='sangar-content-wrapper'>
        <div class='sangar-content'>
            <img src='/images/auto/563081221205874528.jpg' />
            <a href='/images/weixin/thirteenpingtai.jpg' data-lightbox="ff" data-title="50"></a>
            <div class="sangar-textbox">
                <div class="sangar-textbox-inner">
                    <div class="sangar-textbox-content">
                        <p class="sangar-slide-title">关注微信公众号</p>
                        <div class="sangar-slide-content">
                            <p>全球华人交友约会平台</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='sangar-content'>
            <img src='/images/auto/1.png' />
            <a href='/member/auto-join/changjian'></a>
            <div class="sangar-textbox">
                <div class="sangar-textbox-inner">
                    <div class="sangar-textbox-content">
                        <p class="sangar-slide-title">常见问题答疑</p>
                        <div class="sangar-slide-content">
                            <p>还有不懂的问女生客服吧</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='sangar-content'>
            <img src='/images/auto/3.png' />
            <a href='/member/auto-join/fanpai'></a>
            <div class="sangar-textbox">
                <div class="sangar-textbox-inner">
                    <div class="sangar-textbox-content">
                        <p class="sangar-slide-title">被翻牌</p>
                        <div class="sangar-slide-content">
                            <p>被女生主动约的感觉棒棒的</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='sangar-content'>
            <img src='/images/auto/2.png' />
            <a href='http://13loveme.com/date-today'></a>
            <div class="sangar-textbox">
                <div class="sangar-textbox-inner">
                    <div class="sangar-textbox-content">
                        <p class="sangar-slide-title">最新觅约</p>
                        <div class="sangar-slide-content">
                            <p>平台女生都在这里等你哦</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='sangar-content'>
            <img src='/images/auto/4.png' />
            <a href='http://mp.weixin.qq.com/s?__biz=MzAxMDIwMDIxMw==&mid=503683187&idx=1&sn=9e750223ff76edbcdc1a2a044e09a12d&scene=1&srcid=0810NACKLUBWc4Ac6FIQWXO5#wechat_redirect'></a>
            <div class="sangar-textbox">
                <div class="sangar-textbox-inner">
                    <div class="sangar-textbox-content">
                        <p class="sangar-slide-title">平台简介</p>
                        <div class="sangar-slide-content">
                            <p>这是一个正经的平台</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='sangar-content'>
            <img src='/images/auto/5.png' />
            <a href='/member/auto-join/bada'></a>
            <div class="sangar-textbox">
                <div class="sangar-textbox-inner">
                    <div class="sangar-textbox-content">
                        <p class="sangar-slide-title">十三平台八大优势</p>
                        <div class="sangar-slide-content">
                            <p>更多内容搜索十三平台官网</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid" style="margin-top: 10px;padding-bottom:60px;">
    <div class="row">
        <ul id="myTab" class="nav nav-tabs auto-join-member">
            <li class="active" data-sort="2">
                <a href="#membership_ordinary" class="clearfix membership_sort_ch" data-toggle="tab">
                    <div class="col-xs-5 auto-member-name">
                        <span class="in-icon2" style="vertical-align: middle;"></span><span>普通会员</span>
                    </div>
                    <div class="col-xs-6 auto-member-price">
                        <h3>
                            <?php if($area==3){
                                echo 380;
                            } elseif($area==1){
                                echo 180;
                            }else{
                                echo 280;
                            }?>
                        </h3>
                        <h5>享有<span>5</span>项特权</h5>
                        <select class="area__choice" data-name="普通会员" title="areachoice" name="area">
                            <?php if($area==3):?>
                                <option value=3 data-price="380">地区：北上广苏浙</option>
                            <?php elseif($area==1):?>
                                <option value=1 data-price="180">地区：新蒙青甘藏宁琼</option>
                            <?php else:?>
                                <option value=2 data-price="280">地区：包括海外在内的其他地区</option>
                            <?php endif;?>
                        </select>
                    </div>
                    <label for="member_putong" class="col-xs-1 auto-member-choice">
                        <span class="in-con1"></span>
                    </label>
                </a>
                <!--隐藏特权-->
                <div class="hidden-panel">
                    <div class="clearfix membership-vote" style="border-top: none;">
                        <div class="clearfix" style="float: left;width: 50%;border-right: 1px solid #eee;">
                            <div class="vote-up">
                                <h5>有效地区</h5>
                                <div class="vote-up-down-content">一个省或直辖市</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon1"></span>
                            </div>
                        </div>
                        <div class="clearfix" style="float: left;width: 49%;">
                            <div class="vote-up">
                                <h5>有效时间</h5>
                                <div class="vote-up-down-content">一经入会永久有效</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon2"></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix membership-vote" style="border-top: none;">
                        <div class="clearfix" style="float: left;width: 50%;border-right: 1px solid #eee;">
                            <div class="vote-up">
                                <h5>被翻牌</h5>
                                <div class="vote-up-down-content">被女生翻牌索要号码</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon3"></span>
                            </div>
                        </div>
                        <div class="clearfix" style="float: left;width: 49%;">
                            <div class="vote-up">
                                <h5>送地区群</h5>
                                <div class="vote-up-down-content">400人以上所在地区群</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon4"></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix membership-vote" style="border-top: none;">
                        <div class="clearfix" style="float: left;width: 50%;border-right: 1px solid #eee;">
                            <div class="vote-up">
                                <h5>朋友圈福利</h5>
                                <div class="vote-up-down-content">急救通知，妹子福利</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon5"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div href="javascript:;" class="btn-slide">5项特权<span class="triangle_id triangle"></span></div>
            </li>
            <li data-sort="3">
                <a href="#membership_high" class="clearfix membership_sort_ch" data-toggle="tab">
                    <div class="col-xs-5 auto-member-name">
                        <span class="in-icon1" style="vertical-align: middle;"></span><span>高端会员</span>
                    </div>
                    <div class="col-xs-6 auto-member-price">
                        <h3>
                            <?php if($area==3){
                                echo 1880;
                            } elseif($area==1){
                                echo 980;
                            }else{
                                echo 1480;
                            }?>
                        </h3>
                        <h5>享有<span>8</span>项特权</h5>
                        <select class="area__choice" data-name="高端会员" title="areachoice" name="area">
                            <?php if($area==3):?>
                            <option value=3 data-price="1880">地区：北上广苏浙</option>
                            <?php elseif($area==1):?>
                            <option value=1 data-price="980">地区：新蒙青甘藏宁琼</option>
                            <?php else:?>
                            <option value=2 data-price="1480">地区：包括海外在内的其他地区</option>
                            <?php endif;?>
                        </select>
                    </div>
                    <label for="member_gaoduan" class="col-xs-1 auto-member-choice">
                        <span class="in-con1"></span>
                    </label>
                    <img style="position: absolute;left: 0;top:0;width: 45px;" src="/images/auto/recommend.png" />
                </a>
                <!--隐藏特权-->
                <div class="hidden-panel">
                    <div class="clearfix membership-vote" style="border-top: none;">
                        <div class="clearfix" style="float: left;width: 50%;border-right: 1px solid #eee;">
                            <div class="vote-up">
                                <h5>有效地区</h5>
                                <div class="vote-up-down-content">一个省或直辖市</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon1"></span>
                                <!--<img src="/images/auto/server_run_right.png">-->
                            </div>
                        </div>
                        <div class="clearfix" style="float: left;width: 49%;">
                            <div class="vote-up">
                                <h5>有效时间</h5>
                                <div class="vote-up-down-content">一经入会永久有效</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon2"></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix membership-vote" style="border-top: none;">
                        <div class="clearfix" style="float: left;width: 50%;border-right: 1px solid #eee;">
                            <div class="vote-up">
                                <h5>被翻牌</h5>
                                <div class="vote-up-down-content">被女生翻牌索要号码</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon3"></span>
                            </div>
                        </div>
                        <div class="clearfix" style="float: left;width: 49%;">
                            <div class="vote-up">
                                <h5>朋友圈福利</h5>
                                <div class="vote-up-down-content">急救通知，妹子福利</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon4"></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix membership-vote" style="border-top: none;">
                        <div class="clearfix" style="float: left;width: 50%;border-right: 1px solid #eee;">
                            <div class="vote-up">
                                <h5>女生朋友圈内广告</h5>
                                <div class="vote-up-down-content">有75折优惠</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon5"></span>
                            </div>
                        </div>
                        <div class="clearfix" style="float: left;width: 49%;">
                            <div class="vote-up">
                                <h5>送地区群</h5>
                                <div class="vote-up-down-content">全国群</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon6"></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix membership-vote" style="border-top: none;">
                        <div class="clearfix" style="float: left;width: 50%;border-right: 1px solid #eee;">
                            <div class="vote-up">
                                <h5>新发布女生</h5>
                                <div class="vote-up-down-content">可直接得到推荐</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon7"></span>
                            </div>
                        </div>
                        <div class="clearfix" style="float: left;width: 49%;">
                            <div class="vote-up">
                                <h5>增加地区</h5>
                                <div class="vote-up-down-content">可增加会员试用地区</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon8"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div href="javascript:;" class="btn-slide">8项特权<span class="triangle_id triangle"></span></div>
            </li>

            <li data-sort="4">
                <a href="#membership_extreme" class="clearfix membership_sort_ch" data-toggle="tab">
                    <div class="col-xs-5 auto-member-name">
                        <span class="in-icon3" style="vertical-align: middle;"></span><span>至尊会员</span>
                    </div>
                    <div class="col-xs-6 auto-member-price">
                        <h3>
                            <?php if($area==3){
                                echo 4288;
                            } elseif($area==1){
                                echo 3688;
                            }else{
                                echo 3888;
                            }?>
                        </h3>
                        <h5>享有<span>10</span>项特权</h5>
                        <select class="area__choice" data-name="至尊会员" title="areachoice" name="area">
                            <?php if($area==3):?>
                            <option value=3 data-price="4288">地区：北上广苏浙</option>
                            <?php elseif($area==1):?>
                            <option value=1 data-price="3688">地区：新蒙青甘藏宁琼</option>
                            <?php else:?>
                            <option value=2 data-price="3888">地区：包括海外在内的其他地区</option>
                            <?php endif;?>
                        </select>
                    </div>
                    <label for="member_zhizun" class="col-xs-1 auto-member-choice">
                        <span class="in-con1"></span>
                    </label>
                    <img style="position: absolute;left: 0;top:0;width: 45px;" src="/images/auto/recommend.png" />
                </a>
                <!--隐藏特权-->
                <div class="hidden-panel">
                    <div class="clearfix membership-vote" style="border-top: none;">
                        <div class="clearfix" style="float: left;width: 50%;border-right: 1px solid #eee;">
                            <div class="vote-up">
                                <h5>有效地区</h5>
                                <div class="vote-up-down-content">全国可得到推荐</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon1"></span>
                            </div>
                        </div>
                        <div class="clearfix" style="float: left;width: 49%;">
                            <div class="vote-up">
                                <h5>有效时间</h5>
                                <div class="vote-up-down-content">一经入会永久有效</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon2"></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix membership-vote">
                        <div class="clearfix" style="float: left;width: 50%;border-right: 1px solid #eee;">
                            <div class="vote-up">
                                <h5>被翻牌</h5>
                                <div class="vote-up-down-content">被女生翻牌索要号码</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon3"></span>
                            </div>
                        </div>
                        <div class="clearfix" style="float: left;width: 49%;">
                            <div class="vote-up">
                                <h5>朋友圈福利</h5>
                                <div class="vote-up-down-content">急救通知，妹子福利</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon4"></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix membership-vote" style="border-top: none;">
                        <div class="clearfix" style="float: left;width: 50%;border-right: 1px solid #eee;">
                            <div class="vote-up">
                                <h5>女生朋友圈内广告</h5>
                                <div class="vote-up-down-content">可免费一次</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon5"></span>
                            </div>
                        </div>
                        <div class="clearfix" style="float: left;width: 49%;">
                            <div class="vote-up">
                                <h5>送地区群</h5>
                                <div class="vote-up-down-content">全国、各种娱乐群</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon6"></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix membership-vote" style="border-top: none;">
                        <div class="clearfix" style="float: left;width: 50%;border-right: 1px solid #eee;">
                            <div class="vote-up">
                                <h5>新发布女生</h5>
                                <div class="vote-up-down-content">可直接得到推荐</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area"></span>
                                <span class="server_run_area icon7"></span>
                            </div>
                        </div>
                        <div class="clearfix" style="float: left;width: 49%;">
                            <div class="vote-up">
                                <h5>增加地区</h5>
                                <div class="vote-up-down-content">可增加会员试用地区</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon8"></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix membership-vote" style="border-top: none;">
                        <div class="clearfix" style="float: left;width: 50%;border-right: 1px solid #eee;">
                            <div class="vote-up">
                                <h5>女生资料</h5>
                                <div class="vote-up-down-content">有看女生资料资格</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon9"></span>
                            </div>
                        </div>
                        <div class="clearfix" style="float: left;width: 49%;">
                            <div class="vote-up">
                                <h5>往日觅约女生</h5>
                                <div class="vote-up-down-content">入会即有女生推荐</div>
                            </div>
                            <div class="vote-down">
                                <span class="server_run_area icon10"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div href="javascript:;" class="btn-slide">10项特权<span class="triangle_id triangle"></span></div>
            </li>
        </ul>
    </div>
<!--    <div class="row" style="background-color: #fff;margin-top: 5px;padding:10px 0;">
        <h4 style="margin: 0;padding:0 10px;color:#aaa;">会员特权</h4>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="membership_high">
                <div class="col-xs-6 xs6">
                    <h5>有效地区</h5>
                    <h6>一个省或直辖市</h6>
                    <span class="mark">①</span>
                </div>
                <div class="col-xs-6">
                    <h5>有效时间</h5>
                    <h6>一经入会永久有效</h6>
                    <span class="mark">②</span>
                </div>
                <div class="col-xs-6 xs6">
                    <h5>被翻牌</h5>
                    <h6>被女生翻牌索要号码</h6>
                    <span class="mark">③</span>
                </div>
                <div class="col-xs-6">
                    <h5>朋友圈福利</h5>
                    <h6>急救通知，妹子福利</h6>
                    <span class="mark">④</span>
                </div>
                <div class="col-xs-6 xs6">
                    <h5>女生朋友圈内广告</h5>
                    <h6>有75折优惠</h6>
                    <span class="mark">⑤</span>
                </div>
                <div class="col-xs-6">
                    <h5>送地区群</h5>
                    <h6>全国群</h6>
                    <span class="mark">⑥</span>
                </div>
                <div class="col-xs-6 xs6">
                    <h5>新发布女生</h5>
                    <h6>可直接得到推荐</h6>
                    <span class="mark">⑦</span>
                </div>
                <div class="col-xs-6">
                    <h5>增加地区</h5>
                    <h6>可增加会员试用地区</h6>
                    <span class="mark">⑧</span>
                </div>
            </div>
            <div class="tab-pane fade" id="membership_ordinary">
                <div class="col-xs-6 xs6">
                    <h5>有效地区</h5>
                    <h6>一个省或直辖市</h6>
                    <span class="mark">①</span>
                </div>
                <div class="col-xs-6">
                    <h5>有效时间</h5>
                    <h6>一经入会永久有效</h6>
                    <span class="mark">②</span>
                </div>
                <div class="col-xs-6 xs6">
                    <h5>被翻牌</h5>
                    <h6>被女生翻牌索要号码</h6>
                    <span class="mark">③</span>
                </div>
                <div class="col-xs-6">
                    <h5>送地区群</h5>
                    <h6>400人以上所在地区群</h6>
                    <span class="mark">④</span>
                </div>
                <div class="col-xs-6 xs6">
                    <h5>朋友圈福利</h5>
                    <h6>急救通知，妹子福利</h6>
                    <span class="mark">⑤</span>
                </div>
            </div>
            <div class="tab-pane fade" id="membership_extreme">
                <div class="col-xs-6 xs6">
                    <h5>有效地区</h5>
                    <h6>一个省或直辖市</h6>
                    <span class="mark">①</span>
                </div>
                <div class="col-xs-6">
                    <h5>有效时间</h5>
                    <h6>一经入会永久有效</h6>
                    <span class="mark">②</span>
                </div>
                <div class="col-xs-6 xs6">
                    <h5>被翻牌</h5>
                    <h6>被女生翻牌索要号码</h6>
                    <span class="mark">③</span>
                </div>
                <div class="col-xs-6">
                    <h5>朋友圈福利</h5>
                    <h6>急救通知，妹子福利</h6>
                    <span class="mark">④</span>
                </div>
                <div class="col-xs-6 xs6">
                    <h5>女生朋友圈内广告</h5>
                    <h6>可免费一次</h6>
                    <span class="mark">⑤</span>
                </div>
                <div class="col-xs-6">
                    <h5>送地区群</h5>
                    <h6>全国、各种娱乐群</h6>
                    <span class="mark">⑥</span>
                </div>
                <div class="col-xs-6 xs6">
                    <h5>新发布女生</h5>
                    <h6>可直接得到推荐</h6>
                    <span class="mark">⑦</span>
                </div>
                <div class="col-xs-6">
                    <h5>增加地区</h5>
                    <h6>可增加会员试用地区</h6>
                    <span class="mark">⑧</span>
                </div>
                <div class="col-xs-6 xs6">
                    <h5>女生资料</h5>
                    <h6>有看女生资料资格</h6>
                    <span class="mark">⑨</span>
                </div>
                <div class="col-xs-6">
                    <h5>往日觅约女生</h5>
                    <h6>入会即有女生推荐</h6>
                    <span class="mark">⑩</span>
                </div>
            </div>
        </div>
    </div>-->
</div>
<div class="open-member">开通会员</div>
<div class="membership-pay">
    <div class="membership-box">
        <div>
            <h5 style="margin-top: 0;padding:12px 8px;border-bottom: 1px solid #eee;color:gray;margin-bottom: 20px;">
                需支付：<span class="membership-price membership-price3" style="color:#D3B267;"></span>
            </h5>

            <div class="clearfix" style="padding:10px;border-bottom: 1px solid #eee;font-size: 12px;color:gray;">
                <span style="float: left;line-height: 20px;"><label class="membership-name" for="bb"></label> </span>
                <span style="float: right;margin-left: 5px;"><input id="bb" title="" data-type="1" type="radio" name="choice-type" checked></span>
                <span style="color:#E73F78;float: right;font-size: 18px;"><label class="membership-price" for="bb"></label></span>
            </div>

            <div class="clearfix" style="padding:10px;font-size: 12px;color:gray;">
                <span style="float: left;line-height: 20px;"><label for="aa">套餐A：<span class="membership-name"></span>+5位妹子联系方式索取</label></span>
                <span style="color:#E73F78;float: right;margin-left: 5px;"><input title="" data-type="2" type="radio" id="aa" name="choice-type"></span>
                <span style="color:#E73F78;float: right;font-size: 18px;"><label class="membership-price2" for="aa"></label></span>
            </div>

            <input type="hidden" name="member_sort">
            <input type="hidden" name="member_area" value="<?=$area?>">
            <input type="hidden" name="recharge_type">
            <input type="hidden" name="cellphone" value="<?=$cellphone?>">

            <div class="clearfix" style="padding:10px 15px;">
                <div style="float: left;width: 50%;text-align: center;">
                    <span style="font-size: 12px;color:#aaa;">网页端请选择支付宝支付</span>
                    <div style="border: 1px solid #eee;width: 80px;margin: auto;padding:10px 0;border-radius: 5px;">
                        <label for="alipay">

                            <img style="width: 50px;" src="/images/pay/alipay.png">
                            <div class=""><input id="alipay" type="radio" name="pay_type" value="alipay" checked></div>
                        </label>
                    </div>
                </div>
                <div style="float: left;width: 50%;text-align: center;">
                    <span style="font-size: 12px;color:#aaa;">微信端请选择微信支付</span>
                    <div style="border: 1px solid #eee;width: 80px;margin: auto;padding:10px 0;border-radius: 5px;">
                        <label for="weipay">
                            <img style="width: 50px;" src="/images/pay/weipay.png">
                            <div class=""><input id="weipay" type="radio" name="pay_type" value="weipay"></div>
                        </label>
                    </div>
                </div>
            </div>
            <div style="width: 100%;margin-top: 10px;">
                <input id="pay_submits" class="submit_paycs" type="submit" name="确认支付">
            </div>
        </div>
        <span id="box__close">&times;</span>
    </div>
</div>

<script>

    $(function () {

        $('#sangar-example').sangarSlider({
            showAllSlide : true, // show all previous and next slides
            timer : true, // true or false to have the timer
            width : 200, // slideshow width
            height : 120, // slideshow height
            directionalNav : 'show',
            pagination : 'none', // bullet, content-horizontal, content-vertical, none
            paginationContent : ["Lorem Ipsum Dolor", "Dolor Sit Amet", "Consectetur", "Do Eiusmod", "Magna Aliqua"],
            paginationContentWidth : 200, // slideshow width
            textboxOutside : true, // put the textbox to bottom outside
            background:'#fff'
        });
    });

    $(function () {

        $('.submit_paycs').on('click',function () {

            submit_pay();
        });

        $('.area__choice',this).change(function () {

            $(this).siblings('h3').html($('option:selected',this).attr('data-price'));
        });

        $('input[name=cellphone]').keyup(function () {

            if($('input[name=cellphone]').val()!=''){

                $('input[name=cellphone]').css('border-color','#eee');
            }
        });

        $('.open-member').on('click',function () {

            var tt = $('.auto-join-member li.active .area__choice').attr('data-name');
            var price = $('.auto-join-member li.active .auto-member-price select option:checked').attr('data-price');
            var price2 = parseInt(price)+500;
            $('.membership-pay').fadeIn('fast',function () {
                $('.membership-price3').html(price);
                $('.membership-price').html(price);
                $('.membership-name').html(tt);
                $('#aa').val(price2);
                $('#bb').val(price).click();
                $('.membership-price2').html(price2);
            });
        });


        $('input[name=choice-type]',this).change(function () {
            $('.membership-price3').html($(this).val());
            $('input[type=hidden][name=recharge_type]').val($('input[type=radio]:checked').attr('data-type'));
        });


        $('#box__close').on('click',function () {

            $('.membership-pay').fadeOut();
        });

        $(".btn-slide",this).click(function(){
            $(this).siblings(".hidden-panel").slideToggle("slow");
            $(this).children('.triangle_id').toggleClass("triangle-up");
            $(this).children('.triangle_id').toggleClass("triangle");
        });


        $('.open-member').on('click',function () {
            $('input[type=hidden][name=member_sort]').val($('.auto-join-member li.active').attr('data-sort'));
            $('input[type=hidden][name=recharge_type]').val($('input[type=radio]:checked').attr('data-type'));
        });

    });
</script>