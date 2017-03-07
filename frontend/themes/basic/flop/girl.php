
<?php
use yii\helpers\Url;
$this->title="女生档案";
$this->registerCssFile('@web/css/flop/styles.css');
$this->registerCss('

        .navbar,footer,.weibo-share{display:none;}
        .container-box{padding-left:0;padding-right: 0;}
        .wrap,.container,.flop{width:100%;height:100% !important;}
        .flop-choices{padding:0 5% 5px 5%;color:black;border-bottom:1px solid #c3c3c3;}

        .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {color: #555;cursor: default;background-color: transparent; border: none;font-weight:bold;border-bottom:4px solid red;}
        .nav-tabs > li > a{border: none;font-size:24px;padding-bottom:7px;}

        a:hover {color: #000;text-decoration: none;}
        .like-or-not{padding:0 4%;margin-top:2%;}
        .like-list{padding:0 4%;margin-top:5%;width:100%;}
        .like-list i{color:white;font-weight:bold;font-size:26px;margin-left:5px;}
        .like-list:after,.demo__card__info:after,
        .like-or-not:after,.flop-choices:after{content:".";height:0;clear:both;display:block;visibility: hidden;}
        .dropdown-menu > .active > a{background-color:#1F1F21;}
        #like,#not-like,#like2,#not-like2{font-weight:bold;font-size:22px;width:45%;align-text:center;}
        #like,#like2{color:#EB444E;}
        #not-like,#not-like2{color:#F59809;}
        .m--reject,.m--like{font-size:40px;color:red;line-height:200%;padding:20px;}

        .lb-data .lb-caption{font-size:13px !important;}
        /*弹出提示*/
        .my-modal,.my-modal2,.my-modal3{width:100%;height:100%;padding:60px 20px;color:white;background:rgba(56, 56, 56, 0.85);position: absolute;top:0;left:0;z-index:99999;display:none;}
        .my-modal *{line-height: 30px;}
        .btn-default{border:none;box-shadow: 1px 1px 5px gray;}
        #flop-choice-lists {;margin-top: -50px;margin-right: -15px;background-color: rgba(45, 45, 45, 0.9);min-width:120px;padding:0;}
        #flop-choice-lists li a{font-size:20px;color:white;text-align:center;padding:10px 10px;}
        #flop-choice-lists li span{color:#EB444E;}

           header{width:100%;height:44px;background: #EF434F;position: relative;z-index: 10;}
    header a{color:white;position: absolute;}
    header h2{color: #fff;font-size: 16px;font-weight: normal;height:44px;text-align: center;line-height:44px;font-weight: bold;margin-top: 0;}
    header span{display: block;height: 35px;text-indent: 17px;width: 50px;color: #FFF;font-size: 14px;padding-top: 8px;margin-left: -10px;}
    header span img{width: 25px;}

');
?>
<header>
        <div class="header">
                <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
                <h2><?=$this->title?></h2>
                <a href="<?=Url::to(['/flop/teach?sex=1'])?>" style="right:3%;top:0;font-size:18px;line-height: 44px;">教程</a>
        </div>
</header>

<div class="container container-box" style="position: relative;">
        <article class="flop">

                <script>
                        function SetCookie(name, value) {
                                var Days = 30;
                                var exp = new Date();
                                exp.setTime(exp.getTime() + 2 * 24 * 3600 * 1000);//过期时间 一天
                                document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
                        }
                        $(function(){

                                $('#flop-choice-lists li a').on('click',function(){

                                        $('#flop-choice-drop-1').text($(this).text());

                                        if(document.cookie.indexOf("www.13loveme.com=")==-1){


                                                $('.my-modal2').fadeIn();

                                                SetCookie('www.13loveme.com','shisan');
                                        }

                                        before($(this).attr('data-val'));
                                       // $('.flop-content-nope').trigger("click");

                                });
                                $('.my-modal2 a').click(function(){


                                        $('.my-modal2').fadeOut();
                                        $('.my-modal3').fadeIn();
                                        setTimeout("$('.my-modal3').fadeOut();",10000);

                                });
                             /*   $('.my-modal3').click(function(){

                                        $('.my-modal3').fadeOut();
                                });*/

                        });

                </script>
                <div id="myTabContent" class="tab-content" style="width: 100%;height: 90%;">
                        <!--普通翻牌start-->
                        <div class="flop-content tab-pane fade in active" id="home" style="height: 100%;">

                                <!--图片盒子-->
                                <div class="flop__card-cont" style="overflow: hidden;"><div id="flop__card_boxes"></div></div>

                                <!--是否喜欢-->
                                <div class="like-or-not">
                                        <span id="not-like" class="pull-left btn btn-default"><i class="glyphicon glyphicon-remove-circle"></i>NOPE</span>
                                        <span id="like" class="pull-right btn btn-default"><i class="glyphicon glyphicon-heart"></i>LIKE</span>
                                </div>

                                <!--后宫-->
                                <div class="like-list text-center text-bold">
                                        <a class="btn btn-danger btn-lg center-block" href="/flop/flop-list?flag=<?=$_SESSION['flag']?>&sex=1">我的后宫<i class="like-count"></i></a>
                                </div>
                        </div>
                        <!--普通翻牌end-->
                </div>

        </article>

        <!--弹出层start-->
        <!--tan1-->
        <?php if(!isset($_SESSION['tan1'])):?>
        <div id="my-modal-start" class="my-modal text-center" style="padding:30px 15px;display:block;">
                <h1 style="line-height: 50px;">请您先添加<br>十三平台微信客服</h1>
                <h3 style="margin-top: 0;"><?=Yii::$app->params['girl']?></h3>
                <h3 style="margin-top: 0;">截图后在微信端扫描</h3>
                <img style="width: 80%;" src="<?=Yii::getAlias('@web')?>/images/weixin/1.jpg">
                <a class="btn btn-lg btn-danger" style="margin-top: 30px;line-height:20px;" onclick="document.getElementById('my-modal-start').style.display='none'">已经添加点击这里</a>
        </div>
        <?php endif;$_SESSION['tan1']="13loveme.com"?>

        <!--tan2-->
        <div id="my-modal-full" class="my-modal text-center">
                <h1>恭喜</h1>
                <h2>后宫已有6人</h2>
                <h4>快去宠幸他们吧！</h4>
                <hr style="visibility: hidden;">
                <h4>点击查看“我的后宫”，将他们的档案发送至客服获取联系方式</h4>
                <a href="/flop/flop-list?flag=<?=$_SESSION['flag']?>" class="btn btn-lg btn-danger" style="margin-top: 100px;line-height:20px;">我的后宫</a>
        </div>
        <!--弹出层end-->

        <!--tan3-->
        <div id="my-modal-share1" class="my-modal2 text-center">
                <h1>好东西怎能独享</h1>
                <h3 style="margin-top: 50px;">邀请好友一起玩</h3>
                <a class="btn btn-lg btn-danger" style="margin-top: 70%;line-height:20px;padding:10px 50px;">分享链接解锁&nbsp;&nbsp;<span class="glyphicon glyphicon-lock"></span></a>
        </div>
        <!--弹出层end-->
        <!--tan4-->
        <div id="my-modal-share2" class="my-modal3 text-center" style="padding-top: 10px;">
             <img class="img-responsive" style="width: 100%;" src="<?=Yii::getAlias('@web')?>/images/flop/norrow-1.png">
        </div>
        <!--弹出层end-->

</div>

        <script>
                $(document).ready(function () {


                        $('#not-like,#like').click(function(){
                                var xhr = new XMLHttpRequest();
                                var mem_id;
                                if($('.member-id')&&!isNaN($('.member__id').html())){

                                        mem_id = $('.member__id').text();
                                }else {

                                        mem_id=1;
                                }

                                xhr.onreadystatechange = function stateChanged()
                                {
                                        if (xhr.readyState==4 || xhr.readyState=="complete")
                                        {
                                                var data = eval('('+xhr.responseText+')');

                                                $("#flop__card_boxes").empty();
                                                $("#flop__card_boxes").append("" +
                                                    "<div class='demo__card'>"+
                                                    "<div class='member__id hide'>"+data.id+"</div>"+
                                                    "<div class='demo__card__top brown'>"+
                                                    "<a class='flop__img_tan' href='"+data.content+"' data-title='编号:"+data.number+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+data.weight+"kg/"+data.height+"cm"+"' data-lightbox='flop'>" +
                                                    "<div class='demo__card__img' style='background-image: url("+data.path+");background-size: cover;background-position: center;background-repeat: no-repeat;position: relative;'></div>" +
                                                    "</a>"+
                                                    "<div class='demo__card__info' style='padding:10px;'>"+
                                                    "<div class='pull-left'><span>编号："+data.number+"</span></div>"+
                                                    "<div class='pull-right'><span>点击图片看大图</span></div>"+
                                                    "</div>"+
                                                    "</div>"+
                                                    "</div>");

                                        }
                                };
                                xhr.open('get','/index.php/flop/girl-ajax-carefully?id='+mem_id);
                                xhr.send(null);

                        });
                        $('#not-like').trigger("click");


                        $("#like").on('click',function(){

                                var $id = $('.member__id').text();
                                choices($id,1);
                                addflop($id);


                        });
                        $("#not-like").on('click',function(){

                                var $id = $('.member__id').text();
                                choices($id,0);

                        });

                });

                function choices(id,type){

                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function stateChanged()
                        {
                                if (xhr.readyState==4 || xhr.readyState=="complete")
                                {


                                }
                        };
                        if(type==1){

                                /*喜欢*/
                                xhr.open('get','/index.php/flop/flop-like?id='+id);


                        }else if(type==0) {

                                /*不喜欢*/
                                xhr.open('get','/index.php/flop/flop-nope?id='+id);

                        }

                        xhr.send(null);
                }

                function before(val){

                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function stateChanged()
                        {
                                if (xhr.readyState==4 || xhr.readyState=="complete")
                                {

                                        var data = eval('('+xhr.responseText+')');

                                        $("#flop__card_boxes2").empty();
                                        $("#flop__card_boxes2").append("" +
                                            "<div class='demo__card'>"+
                                            "<div class='member__id2 hide'>"+data.id+"</div>"+
                                            "<div class='demo__card__top brown'>"+
                                            "<a class='flop__img_tan' href='"+data.content+"' data-title='编号:"+data.number+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+data.weight+"kg/"+data.height+"cm"+"' data-lightbox='sdf'>" +
                                            "<div class='demo__card__img' style='background-image: url("+data.path+");background-size: cover;background-repeat: no-repeat;'></div></a>"+
                                            "<div class='demo__card__info' style='padding:10px;'>"+
                                            "<div class='pull-left'><span>编号："+data.number+"</span></div>"+
                                            "<div class='pull-right'><span>"+data.weight+"kg</span> / <span>"+data.height+"cm</span></div>"+
                                            "</div>"+
                                            "</div>"+
                                            "</div>");
                                }
                        };

                        if(val==0){

                                xhr.open('get','/index.php/flop/ajax-carefully?type=0');

                        }else if(val==1){

                                xhr.open('get','/index.php/flop/ajax-carefully?type=1');

                        } else if(val==2){
                                xhr.open('get','/index.php/flop/ajax-carefully?type=2');

                        }



                        xhr.send(null);
                }

                function addflop(id){


                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function stateChanged()
                        {
                                if (xhr.readyState==4 || xhr.readyState=="complete")
                                {
                                        $('.like-count').html(xhr.responseText);
                                        if(xhr.responseText==6){

                                                document.getElementById('my-modal-full').style.display='block';

                                        }

                                }
                        };

                        xhr.open('get','/index.php/flop/add-flop-list?id='+id);

                        xhr.send(null);


                }

        </script>

