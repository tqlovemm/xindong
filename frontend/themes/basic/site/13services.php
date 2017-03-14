<?php
use yii\web\View;
    $this->title = '十三服务';
    $this->registerJsFile(Yii::getAlias('@web')."/js/TouchSlide.1.1.source.js",['position' => View::POS_HEAD]);
    $this->registerCss('
    
        .service-title{padding: 30px 10px; background-color: #F1DDE6;text-align: center;}
        .service-china{color:#D94071;font-weight: bold;}
        .service-english{color:#fff;}
        .service-up{background-color: #fff;padding:5px 50px;text-align: center;}
        .service_1{}
        .service_1 .s_box{background-color: #fff;}
        .s_box .col-xs-6{padding: 0;}
        .s_box img{width: 100%;}
        .box_text{background-color: #3A4885;padding:20px 30px;color:#fff;}
        .box_text h5{line-height: 20px;}
        .service_13{background-color: #fff;padding:0;padding-bottom:20px;}
        .service_13 .row{margin:0;}
        .service_13 hr{border-top: 1px solid #DFDFDF;}
        
            .send {
                padding:50px 5px;
                position:relative;
                width:300px;
                background:#CC4E7D;
                border-radius:10px; /* 圆角 */
                margin:100px auto 0;
                color:#fff;
            } .send_1 {
                padding:50px 5px;
                position:relative;
                width:300px;
                background:#3D4886;
                border-radius:10px; /* 圆角 */
                margin:100px auto 0;
                color:#fff;
            }
            
            .send .arrow {
                position:absolute;
                top:115px;
                right:-90px; /* 圆角的位置需要细心调试哦 */
                width:0;
                height:0;
                font-size:0;
                border-top: 70px solid #fff;
                border-right: 30px solid #fff;
                border-left: 60px solid #CC4E7D;
                border-bottom: 0 solid #fff;
            }  
            .send_1 .arrow_1 {
                position:absolute;
                top:115px;
                left:-90px; /* 圆角的位置需要细心调试哦 */
                width:0;
                height:0;
                font-size:0;
                border-top: 70px solid #fff;
                border-right: 60px solid #3D4886;
                border-left: 30px solid #fff;
                border-bottom: 0 solid #fff;
            }
            
                   .brand a{
        
            text-align: center;
            position: relative;
        }
        .brand img{
            width: 100%;
            height: 240px;
        }
        .brand .info{
            display: none;
            background-color: #f0f0f0;
            color: #369242;
            text-align:center;
        }
        .brand .info h5{line-height:26px;}
        .vertical .info{
            padding:50px 10px;
            width: 0;
            height: 240px;
            margin: 0 auto;
        }
        
          .focus{ width:100%; height:inherit;  margin:0 auto; position:relative; overflow:hidden;   }
        .focus .hd{ width:100%; height:11px;  position:absolute; z-index:1; bottom:0px; text-align:center;  }
        .focus .hd ul{ display:inline-block; height:10px; padding:0 5px; background-color:rgba(255,255,255,0.7);
            -webkit-border-radius:5px; -moz-border-radius:5px; border-radius:5px; font-size:0; vertical-align:top;
        }
        .focus .hd ul li{ display:inline-block; width:10px; height:10px; -webkit-border-radius:5px; -moz-border-radius:5px; border-radius:5px; background:#8C8C8C; margin:0 5px;  vertical-align:top; overflow:hidden;   }
        .focus .hd ul .on{ background:#FE6C9C;  }
        .focus .bd{ position:relative; z-index:0; }
        .focus .bd li img{ max-width:100%;  height:inherit;}
        .focus .bd li a{ -webkit-tap-highlight-color:rgba(0, 0, 0, 0);}
        .focus .bd .col-md-4{padding:0 5px;}
        .bd .row{margin:0;}
        #vertical .col-md-4{padding:0;}
        .service_phone{position: relative;padding: 50px 0;}
        .service_phone_img{position: absolute;top:0;left:16%;width:170px;}
        .service_phone_content{height: 240px;color:#fff;padding:20px 0;}
        .service_phone_content_title{margin-top: 0;}
        .service_phone_content_icon{padding:5px 10px;background-color:rgb(222, 76, 127);}
            .service-method .boy,.service-method .girl{text-align: left;font-weight: bold;padding-left:20px;}
 
            .service-method img{width:100%}
             .service-method .col-md-6{padding:10px;}
                 .method-girl{text-align: right;}
        @media (max-width: 1320px) {
        .box_text h2{font-size:16px;}
        .box_text h5{font-size:12px;line-height: 16px;}
        } 
        
        @media (max-width: 1000px) {
            .box_text{padding:1px 10px;}
            .service-method{background-color:#efefef;}
            .service-method .boy{text-align: left;padding-left:20px;}
            .service-method .girl{text-align: left;padding-left:20px;}
        } 
        
        @media (max-width: 992px) {
            .service_1 .s_box{background-color: #fff;padding:0;}
            .box_text{padding:10px 10px;}
            .service-method .col-md-6{padding:0;margin-bottom:10px;}
     .method-girl{text-align: center;}
     .method-boy{text-align: center;}
        }  
        @media (max-width: 500px) {
            .service-method img{width:100%}
            .service_1 .s_box{background-color: #fff;padding:0;}
            .box_text{padding:5px;over-flow:hidden;}
            .box_text h2{margin-top:0}
            .service_phone_img{position: absolute;top:20px;left:5px;width:100px;}
            .service_phone{padding-top:0;}
        }
        .service-method{position: relative;}
    
       
        .method-center-img{position: absolute;width: 180px;height: 180px;background-image: url(\'/images/service/u=3420061895,3746714130&fm=21&gp=0.jpg\');background-size: cover;border-radius: 50%;left: 50%;top:20%;
                            margin-left: -90px;margin-top: -90px;text-align: center;font-size: 16px;color:#fff;padding:50px 10px;font-weight:bold;}
   
 
    ');
?>
<?php if ($this->beginCache($id=3, ['duration' => 86400])) :?>
<div class="container service_13">
    <div class="row service-title">
        <h2 class="service-china">十三服务</h2>
        <h2 class="service-english">SERVICE</h2>
    </div>
    <div class="row service-up">
        <div style="margin-bottom: 50px;">
            <span style="background-color: #CF4284;color: #fff;padding:5px 10px;font-size: 20px;">服务项目</span>
        </div>
        <h5 style="font-weight: bold;color: #000;margin-bottom: 40px;">十三平台通过微信app网站等多个项目，为广大男女提供无微不至、随时随地的服务</h5>
    </div>
    <div class="service_1">
        <div id="vertical" class="row s_box brand vertical">
            <a class="col-md-4">
                <img alt="" src="/images/service/fanpai.png" />
                <div class="info" style="background-color: #3A4885;color: #fff;">
                    <h2 style="margin-top: 0;">极致翻牌推荐服务</h2>
                    <h5>我们13平台的汉子都会建立一个基本档案，可供妹子挑选，一旦妹子有需求， 并选中你后，你将迅速得到妹子联系方式，并开启一场速成约会。</h5>
                </div>
                <h6 style="color:gray;">极致翻牌推荐服务</h6>
            </a>
            <a class="col-md-4">
                <img alt="" src="/images/service/couple.png" />
                <div class="info" style="background-color: #DE6BA6;color:#fff;">
                    <h2 style="margin-top: 0;">十三男女勾搭群</h2>
                    <h5>我们拥有：华东，华南，华北，华中，海外微信群，群内人数300人以上； 并同时建立了北京、上海、广州、深圳、成都等 地首批城市微信群，人数在不断的增加，并保持着合理的男女比例。</h5>
                </div>
                <h6 style="color:gray;">十三男女勾搭群</h6>
            </a>
            <a class="col-md-4">
                <img alt="" src="/images/service/phone.png" />
                <div class="info" style="background-color: #D84071;color:#fff;">
                    <h2 style="margin-top: 0;">会员专属APP社区</h2>
                    <h5>在这里有停不下来的互动，任何时候你都能 在十三平台app上找到和你互动的人，不会 遇到发信息没有人回，想聊天没有人理的情况。</h5>
                </div>
                <h6 style="color:gray;">会员专属APP社区</h6>
            </a>
        </div>
    </div>
    <div class="row" style="background:url(/images/service/photo.png) center;background-repeat:no-repeat;padding:155px 0;margin-top: 20px;"></div>
    <div id="focus" class="focus" style="margin-top: 15px;">
        <div class="hd">
            <ul></ul>
        </div>
        <div class="bd">
            <ul>
                <li>
                    <div class="row service_phone">
                        <img class="img-responsive service_phone_img" src="/images/service/weibo.png">
                        <div style="background-color: #DE6BA6;" class="service_phone_content">
                            <div class="col-xs-offset-5 col-md-offset-4 col-md-4">
                                <h1 class="service_phone_content_title">微博</h1>
                                <h5><span class="service_phone_content_icon">@十三交友官博</span></h5>
                                <ul style="line-height: 30px;">
                                    <li>各种欢脱的线上线下活动</li>
                                    <li>平台最新动态</li>
                                    <li>状态更新幅度快</li>
                                </ul>
                            </div>
                            <div class="col-xs-3 visible-md visible-lg" style="padding: 0;">
                                <img src="/images/service/weibo2.png" class="img-responsive">
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row service_phone">
                        <img class="img-responsive service_phone_img" src="/images/service/miyue.png">
                        <div style="background-color: #EF8383;" class="service_phone_content">
                            <div class="col-xs-offset-5 col-md-offset-4 col-md-4">
                                <h1 class="service_phone_content_title">最新觅约</h1>
                                <h5><span class="service_phone_content_icon">13loveme.com</span></h5>
                                <ul style="line-height: 30px;">
                                    <li>觅约交友功能满足各等级会员的不同需求</li>
                                    <li>平台最新通知</li>
                                    <li>十三平台情报</li>
                                </ul>
                            </div>
                            <div class="col-xs-3 visible-md visible-lg" style="padding: 0;">
                                <img src="/images/service/miyue2.png" class="img-responsive">
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row service_phone">
                        <img class="img-responsive service_phone_img" src="/images/service/fuwuhao.png">
                        <div style="background-color: #F1DDE6;" class="service_phone_content">
                            <div class="col-xs-offset-5 col-md-offset-4 col-md-4">
                                <h1 class="service_phone_content_title" style="color: gray;">服务号</h1>
                                <h5><span class="service_phone_content_icon">xinidong31</span></h5>
                                <ul style="line-height: 30px;color:gray;">
                                    <li>各种欢脱的线上线下活动</li>
                                    <li>平台最新动态</li>
                                    <li>状态更新幅度快</li>
                                </ul>
                            </div>
                            <div class="col-xs-3 visible-md visible-lg" style="padding: 0;">
                                <img style="margin-top: -50px;" src="/images/service/fuwuhao.gif" class="img-responsive">
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row service_phone">
                        <img class="img-responsive service_phone_img" src="/images/service/dingyue.png">
                        <div style="background-color: #fff;" class="service_phone_content">
                            <div class="col-xs-offset-5 col-md-offset-4 col-md-4">
                                <h1 class="service_phone_content_title" style="color: #000;">订阅号</h1>
                                <h5><span class="service_phone_content_icon">Bplatform</span></h5>
                                <ul style="line-height: 30px;color: #000;">
                                    <li>男女活动话题</li>
                                    <li>互动小游戏</li>
                                    <li>男生女生的寻约消息推送！</li>
                                </ul>
                            </div>
                            <div class="col-xs-3 visible-md visible-lg" style="padding: 0;">
                                <img style="margin-top: 20px;" src="/images/service/dongtu.gif" class="img-responsive">
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="row visible-lg visible-md" style="background:url(/images/service/background.png) center;background-repeat:no-repeat;padding:155px 0;margin-top: 20px;"></div>
    <div class="row visible-sm visible-xs" style="background:url(/images/service/girlface.png) center;background-repeat:no-repeat;background-size: contain;padding:60px 0;margin-top: 20px;"></div>
   <div class="row service-up">
        <div style="margin-bottom: 0;">
            <span style="background-color: #CF4284;color: #fff;padding:5px 10px;font-size: 20px;">服务模式</span>
        </div>
    </div>

    <div class="row service-method">
        <div class="col-md-6 method-boy">
            <h4 class="boy">如果你是男生</h4>
           <img src="/images/service/174776714338423506.jpg">
        </div>
        <div class="col-md-6 method-girl">
            <h4 class="girl">如果你是女生</h4>
            <img src="/images/service/481035858582662669.jpg">
        </div>
      <!--  <div class="method-center-img visible-lg">
            您只需提供您的真实个人资料
            审核通过后，将成为我们的优质会员
        </div>-->
    </div>
<!--
    <div class="row">
        <div class="col-xs-offset-2 col-xs-3" style="color:#4A63AC;">
            <h3>If You Ara A Boy</h3>
            <h4>如果你是男生</h4>
            <img class="img-responsive" src="/images/service/manruhui.jpg">
        </div>
        <div class="col-xs-6">
            <div class="send_1">
                <ul>
                    <li>您只需提供您的真实个人资料</li>
                    <li>审核通过后，选择成为我们的优质会员</li>
                    <li>可享受到平台服务：被女生翻牌联系，男女混合联系群，定期男女随机配对福利</li>
                </ul>
                <span class="arrow_1"></span>
            </div>
        </div>
    </div>
    <div class="row" style="margin-bottom: 30px;">
        <div class="col-xs-6 col-xs-offset-1">
            <div class="send">
                <ul>
                    <li>您只需提供您的真实个人资料</li>
                    <li>我们将平台男生档案发送至您的聊天窗口，在线选择心仪的TA</li>
                    <li>十三将迅速通知被选择的男生，他将及时联系您，并安排一次满意的约会交友</li>
                </ul>
                <span class="arrow"></span>
            </div>

        </div>
        <div class="col-xs-3" style="color:#DE6AA5;">
            <h3>If You Ara A Boy</h3>
            <h4>如果你是男生</h4>
            <img class="img-responsive" src="/images/service/girlruhui.jpg">
        </div>
    </div>-->
</div>
<?php $this->endCache();endif;?>
<script>
    window.onload = function() {
        var height = $('.s_box img').innerHeight();
        $('.box_text').css('height',height);
    };

    //品牌翻转
    var turn = function(target,time,opts){
        target.find('a').hover(function(){
            $(this).find('img').stop().animate(opts[0],time,function(){
                $(this).hide().next().show();
                $(this).next().animate(opts[1],time);
            });
        },function(){
            $(this).find('.info').animate(opts[0],time,function(){
                $(this).hide().prev().show();
                $(this).prev().animate(opts[1],time);
            });
        });
    };
    var verticalOpts = [{'width':0},{'width':'100%'}];
    turn($('#vertical'),100,verticalOpts);
    var horizontalOpts = [{'height':0,'top':'120px'},{'height':'240px','top':0}];
    turn($('#horizontal'),100,horizontalOpts);

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
