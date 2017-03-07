<?php
    $cookie = Yii::$app->request->cookies;
?>
<html>
<head>
    <title>自动入会</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <link rel="stylesheet" href="/css/auto/sangarSlider.css" type="text/css" media="all">
    <link rel="stylesheet" href="/css/auto/default.css" type="text/css" media="all">
    <script type="text/javascript" src="/js/auto/main.js"></script>
    <style>
        input[type="radio" i] { margin: 4px 2px 0 10px; }
        .membership-pay{position: fixed;bottom:0;background-color: rgba(142, 142, 142, 0.46);height: 100%;width: 100%;z-index: 9;display: none;}
        .membership-box{height: 370px;position: absolute;bottom: 0;width: 100%;background-color: #fff;}
        .membership-price3:after{content: '元';}
        .sangar-slideshow-container div.sangar-timer{display: none !important;}
        #pay_submits{display: block;width: 50%;margin: 0 auto;background-color: transparent;text-align: center;padding:5px;font-size: 20px;border: 1px solid #D3B267;color:#D3B267;border-radius: 20px;}
        .server_run_area{width:20px;height:30px;display: inline-block;background-image: url("/images/auto/b169be1feeb2.jpg");}
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
        .membership-type{ background-color: #f6f6f6;padding:10px; }
        .membership-type-title{ float: left;font-size: 20px;line-height: 35px;padding-left:10px; }
    </style>
</head>
<body>
<div class="membership-pay">
    <div class="membership-box">
        <div>
            <h5 style="margin-top: 0;padding:12px 8px;border-bottom: 1px solid #eee;color:gray;margin-bottom: 20px;">
                选择地区：<select id="area__choice" title="areachoice" name="area" style="background-color: #fff;border:1px solid #eee;outline: none;padding:2px 0;border-radius: 4px;margin-right: 10px;width: 100px;">
                    <option id="select3" data-area="3">北上广苏浙</option>
                    <option id="select1" data-area="1">新蒙青甘藏宁琼</option>
                    <option id="select2" data-area="2">包括海外在内的其他地区</option>
                </select>
                需支付：<span class="membership-price membership-price3" style="color:#D3B267;"></span>
            </h5>

            <div class="clearfix" style="padding:10px;border-bottom: 1px solid #eee;font-size: 12px;color:gray;">
                <span style="float: left;line-height: 20px;"><label class="membership-name" for="bb"></label></span>
                <span style="float: right;"><input id="bb" title="" data-type="1" type="radio" name="choice-type" checked></span>
                <span style="color:#E73F78;float: right;font-size: 18px;"><label class="membership-price" for="bb"></label></span>
            </div>
            <div class="clearfix" style="padding:10px;font-size: 12px;color:gray;">
                <span style="float: left;line-height: 20px;"><label for="aa">套餐A：<span class="membership-name"></span>+5位妹子联系方式索取</label></span>
                <span style="color:#E73F78;float: right;"><input title="" data-type="2" type="radio" id="aa" name="choice-type"></span>
                <span style="color:#E73F78;float: right;font-size: 18px;"><label class="membership-price2" for="aa"></label></span>
            </div>

            <input type="hidden" name="member_sort">
            <input type="hidden" name="member_area">
            <input type="hidden" name="recharge_type">
            <div class="" style="padding:5px 10px;font-size: 12px;color:gray;"><label>手机号码：</label><input type="number" maxlength="11" pattern="[0-9]*"  style="outline: none;border:1px solid #eee;padding:4px 12px;border-radius: 4px;box-shadow: inset 0 1px 1px rgba(0,0,0,.075);" name="cellphone" placeholder="请输入手机号码" value=""></div>
            <div class="clearfix" style="padding:10px 35px;">
                <div style="float: left;width: 50%;text-align: center;">
                    <div style="border: 1px solid #eee;width: 80px;margin: auto;padding:10px 0;border-radius: 5px;">
                        <label for="alipay">
                            <img style="width: 50px;" src="/images/pay/alipay.png">
                            <div class=""><input id="alipay" type="radio" name="pay_type" value="alipay" checked></div>
                        </label>
                    </div>
                </div>
                <div style="float: left;width: 50%;text-align: center;">
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
        <span id="box__close" style="width: 16px;height:16px;position: absolute;top:-12px;right: 0;padding:5px;background-color: #fff;border-radius: 50%;font-weight: bold;text-align: center;line-height: 16px;">&times;</span>
    </div>
</div>
<div class='sangar-slideshow-container' id='sangar-example' style="margin-top: 4px;">
    <div class='sangar-content-wrapper'>
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
<div class="membership-type">会员类型</div>
<div class="sangar-content2-wrapper">
    <div class="membership membership-high">
        <div class="clearfix" style="padding:10px 10px 0;">
            <div class="clearfix membership-sort">
                <span class="membership-type-icon"><img style="width:35px;" src="/images/auto/gaoduan2.png"></span><span class="membership-type-title">高端会员</span>
                <span class="membership-open-box" data-sort="3" data-price1="980" data-price2="1480" data-price3="1880" style="float: right;">
                   <a style="display: block;" href="javascript:;" class="membership-open">开通</a>
                </span>
            </div>
        </div>
        <div class="clearfix membership-banner"><span style="float: left;">全部特权</span><span style="float:right;">超过8项</span></div>
        <div class="clearfix membership-vote">
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
        <!--隐藏特权-->
        <div class="hidden-panel">
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
            <div class="clearfix membership-vote" style="border-top: none;">
                <div class="clearfix" style="float: left;width: 50%;border-right: 1px solid #eee;">
                    <div class="vote-up">
                        <h5>...</h5>
                    </div>
                </div>
            </div>
        </div>
        <a href="javascript:;" class="btn-slide">还有6项特权<span class="triangle_id triangle"></span></a>
    </div>
    <div class="membership membership-ordinary">

      <div class="clearfix" style="padding:10px 10px 0;">
          <div class="clearfix membership-sort">
              <span class="membership-type-icon"><img style="width:35px;" src="/images/auto/putong2.png"></span>
              <span class="membership-type-title">普通会员</span>
              <span class="membership-open-box" data-sort="2" data-price1="180" data-price2="280" data-price3="380" style="float: right;"><a style="display: block;" href="javascript:;" class="membership-open">开通</a></span>
          </div>
      </div>
      <div class="clearfix membership-banner"><span style="float: left;">全部特权</span><span style="float:right;">超过5项</span></div>
      <div class="clearfix membership-vote">
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
      <!--隐藏特权-->
      <div class="hidden-panel">
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
              <div class="clearfix" style="float: left;width: 49%;">
                  <div class="vote-up">
                      <h5>...</h5>
                  </div>
              </div>
          </div>
      </div>
      <a href="javascript:;" class="btn-slide">还有3项特权<span class="triangle_id triangle"></span></a>
    </div>
    <div class="membership membership-extreme">
        <div class="clearfix" style="padding:10px 10px 0;">
            <div class="clearfix membership-sort">
                <span class="membership-type-icon"><img style="width:35px;" src="/images/auto/zhizun2.png"></span>
                <span class="membership-type-title">至尊会员</span>
                <span class="membership-open-box" data-sort="4" data-price1="3688" data-price2="3888" data-price3="4288" style="float: right;"><a style="display: block;" href="javascript:;" class="membership-open">开通</a></span>
            </div>
        </div>
        <div class="clearfix membership-banner"><span style="float: left;">全部特权</span><span style="float:right;">超过10项</span></div>
        <div class="clearfix membership-vote">
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
        <!--隐藏特权-->
        <div class="hidden-panel">
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
            <div class="clearfix membership-vote" style="border-top: none;">
                <div class="clearfix" style="float: left;width: 50%;border-right: 1px solid #eee;">
                    <div class="vote-up">
                        <h5>...</h5>
                    </div>
                </div>
            </div>
        </div>
        <a href="javascript:;" class="btn-slide">还有8项特权<span class="triangle_id triangle"></span></a>
    </div>
</div>
</body>
</html>

<script>
    function submit_pay(){

        if(confirm('确认开通会员吗？')){
            if($('#area__choice').val()==null){
                alert('请选择地区');
                return false;
            }
            if($('input[name=cellphone]').val()==''){
                confirm('请输入手机号码');
                $('input[name=cellphone]').css('border-color','red');
                $('input[name=cellphone]').focus();
                return false;
            }
/*            window.location.href='/member/user/auto-join-pay?data='+
                $('input[type=hidden][name=member_sort]').val()+','+
                $('input[type=hidden][name=member_area]').val()+','+
                $('input[type=hidden][name=recharge_type]').val()+','+
                $('input[name=pay_type]:checked').val()+','+
                $('input[name=cellphone]').val()+','+<?php echo $cookie->getValue('auto_join_13pt')?>;*/
        }
        return false;
    }
    $('input[name=cellphone]').keyup(function () {

        if($('input[name=cellphone]').val()!=''){

            $('input[name=cellphone]').css('border-color','#eee');
        }
    });

    $('.membership-pay').bind("touchmove",function(e){
        e.preventDefault();
    });
</script>
<script>
    $(function () {

        $('.submit_paycs').on('click',function () {

            submit_pay();
        });

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

        $('#box__close').click(function () {
            $('.membership-pay').fadeOut();
        });

        $('#area__choice').change(function () {

            $('.membership-price').html($(this).val());
            $('.membership-price2').html(parseInt($(this).val())+500);

            $('#bb').val($(this).val()).click();
            $('#aa').val(parseInt($(this).val())+500);
            $('input[type=hidden][name=member_area]').val($('#area__choice option:selected').attr('data-area'));
            $('input[type=hidden][name=recharge_type]').val($('input[type=radio]:checked').attr('data-type'));
        });

        $('.membership-open-box',this).click(function () {

            $('.membership-name').html($(this).siblings(".membership-type-title").html());

            $('#select3').attr('value',$(this).attr('data-price3'));
            $('#select2').attr('value',$(this).attr('data-price2'));
            $('#select1').attr('value',$(this).attr('data-price1'));

            $('.membership-price').html($(this).attr('data-price3'));
            $('.membership-price2').html(parseInt($(this).attr('data-price3'))+500);

            $('#bb').val(parseInt($(this).attr('data-price3')));
            $('#aa').val(parseInt($(this).attr('data-price3'))+500);

            $('input[type=hidden][name=member_sort]').val($(this).attr('data-sort'));
            $('input[type=hidden][name=member_area]').val($('#area__choice option:selected').attr('data-area'));
            $('input[type=hidden][name=recharge_type]').val($('input[type=radio]:checked').attr('data-type'));

            $('.membership-pay').fadeIn('slow');
        });

        $(".btn-slide",this).click(function(){
            $(this).siblings(".hidden-panel").slideToggle("slow");
            $(this).children('.triangle_id').toggleClass("triangle-up");
            $(this).children('.triangle_id').toggleClass("triangle");
        });

        $('input[name=choice-type]',this).change(function () {
            $('.membership-price3').html($(this).val());
            $('input[type=hidden][name=recharge_type]').val($('input[type=radio]:checked').attr('data-type'));
        });


    });
</script>