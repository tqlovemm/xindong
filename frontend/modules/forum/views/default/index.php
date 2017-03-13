<?php
$this->title = '骗子&红包婊打击行动';
$this->registerCss("
    .box{background-color:#fff;border-bottom:1px solid #F1F1F1;padding:8px 0;}
    .list-group.list-inline li{width:22%;padding:10px;color:#bbb;}
    .list-group.list-inline .glyphicon{color:#bbb;}
    .thread-list{max-width:768px;margin:auto;}
    .thread-list .col-xs-12{padding:0;}
    .thread-list .row{margin:0;}
    .thread-list .list-group{margin-bottom:0;}
    .thread-list .col-xs-6{padding:0;width:49.7%;}
    .thread-list .col-xs-4{padding:0;width:32.9%;}
    .up_down_active{color:red !important;font-size:16px}
    .baoliao{background-color: #fcfcfc;border-bottom: 1px solid #F2F1F1;text-align: right;padding-right: 10px;word-spacing: -14px;z-index:20;}
    #mychoose{z-index:22;width:80px;position:absolute;right:2%;border:1px solid #F1F1F1;background-color:#fff;text-align:center;box-shadow:2px 2px 2px #D0D0D0;border-radius:4px;}
    #mychoose dl dd{height:28px; line-height:28px;}
    dl,dd{padding:0;margin:0}
    .baoliao a:hover{color:#C1C1C1}
        @media (max-width:768px){
            footer{display:none;}
            .img-main a{min-height:200px;display: block;}
            .date-today{padding:10px 5px;}
            .row1-n1{width:100%;padding:10px 10px;}
            .jiuhuo-img{padding:10px 5px;}
        }
    .navbar-custom{z-index:999;width:100%;}
    .container{width:100%;}
    .am-gallery{padding:0 !important;}
    .am-gallery-overlay .am-gallery-item img{width:auto !important;}
");

$this->registerJs("
        $(function() {
            $('img.lazy').lazyload({effect: 'fadeIn'});
        });
    
    ");

$pre_url = Yii::$app->params['threadimg'];
?>

<div class="thread-list" style="z-index: -1;">
    <div class="baoliao">
      <a class="glyphicon glyphicon-pencil news" style="font-size:16px;line-height: 40px;" href="/forum/default/before-push-thread">
          <span style="font-size: 14px;">爆料</span>
      </a>
    </div>
    <div class="info-list">
    <?php foreach ($model as $item):if($item['type']==1):?>
        <div class="box myfirst" data-id="<?=$item['tid']?>">
            <div class="row">
                <a href="/forum/default/view?tid=<?=$item['tid']?>&top=bottom">
                    <h5 style="padding: 10px 5px;margin: 0;line-height: 20px;"><?=\yii\helpers\Html::encode(\yii\myhelper\Helper::truncate_utf8_string($item['content'],35))?></h5>
                    <div class="img-box clearfix">
                    <?php if(count($item['img'])==1):?>
                    <?php foreach ($item['img'] as $key=>$img):?>
                        <div style="padding: 0 0 0 5px;" class="col-xs-6">
                            <img class="img-responsive lazy" data-original="<?=$pre_url.$img['img']?>">
                        </div>
                    <?php endforeach;?>
                    <?php elseif(count($item['img'])==2):?>
                        <?php foreach ($item['img'] as $key=>$img):?>
                            <div class="col-xs-6" style="<?php if($key==1){echo 'float:right;';}?>;height: 130px;overflow: hidden;">
                                <img class="img-responsive lazy" data-original="<?=$pre_url.$img['img']?>">
                            </div>
                        <?php endforeach;?>
                    <?php elseif(count($item['img'])>=3):?>
                        <?php foreach ($item['img'] as $key=>$img):?>
                            <div class="col-xs-4" style="<?php if($key==1){echo 'margin:0 0.6%;';}?>;<?php if($key==2){echo 'float:right;';}?>;height: 105px;overflow: hidden;">
                                <img class="img-responsive lazy" data-original="<?=$pre_url.$img['img']?>">
                            </div>
                            <?php if($key==2) break;endforeach;?>
                    <?php endif;?>
                    </div>
                </a>
            </div>
            <div class="row">
                <ul class="list-group list-inline">
                    <li class="thumbs_up" onclick="thumbs_total(<?=$item['tid']?>,1,this)"><span class="glyphicon glyphicon-thumbs-up <?php if($item['thumbs']['type']==1){echo 'up_down_active';}?>"></span> <span class="count"><?=$item['thumbsup_count']?></span></li>
                    <li class="thumbs_down" onclick="thumbs_total(<?=$item['tid']?>,2,this)"><span class="glyphicon glyphicon-thumbs-down <?php if($item['thumbs']['type']==2){echo 'up_down_active';}?>"></span> <span class="count"><?=$item['thumbsdown_count']?></span></li>
                    <li><a href="/forum/default/view?tid=<?=$item['tid']?>&top=bottom"><span class="glyphicon glyphicon-comment"></span> <span><?=count($item['comments'])?></span></a></li>
                </ul>
            </div>
        </div>
    <?php endif; endforeach;?>
    </div>
</div>

<script>

    var load_flag=false;
    $(function(){

        $(window).scroll(function(){

            if(load_flag){
                return;
            }

            var totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());

            if(totalheight>=$(document).height()){

                loadMore();

            }

        });

    });

    function loadMore(){

        var id = $('.info-list').children('.myfirst:last').data('id');
        $.get('/forum/default/ajax-index?id=' + id, function (data) {
            var parsedJson = $.parseJSON(data);
            if (parsedJson == null || parsedJson == '') {

                if ($('.none').html() != null) {
                    return false;
                } else {
                    $('.info-list').append("<div class='none' style='margin-top: -10px;;text-align: center;font-size: 14px;color: grey;background-color: #FCFCFC;padding: 3px 0;'>加载完毕...</div>");
                }
            } else {
                $('.info-list').append(parsedJson);
            }
        });

    }

    function thumbs_total(tid,type,content) {
        var conx = $(content);

        $.get('/forum/default/thumbs?tid='+tid+'&type='+type,function (data) {
            if(data == 4){
                if(confirm('请先登陆')){
                    window.location.href='/forum/default/choice-login';
                }else{
                    return false;
                }

            }
            var up_down = $.parseJSON(data);
            if(type==1){
                conx.children('.count').html(up_down.up);
                conx.siblings('.thumbs_down').children('.count').html(up_down.down);
                if(up_down.status==10){
                    conx.children('.glyphicon').removeClass('up_down_active');
                }else {
                    conx.children('.glyphicon').addClass('up_down_active');
                    conx.siblings('.thumbs_down').children('.glyphicon').removeClass('up_down_active');
                }
            }else {
                conx.children('.count').html(up_down.down);
                conx.siblings('.thumbs_up').children('.count').html(up_down.up);
                if(up_down.status==10){
                    conx.children('.glyphicon').removeClass('up_down_active');
                }else {
                    conx.children('.glyphicon').addClass('up_down_active');
                    conx.siblings('.thumbs_up').children('.glyphicon').removeClass('up_down_active');
                }
            }

        });

    }
</script>
<script src="/js/datejs/amazeui.js"></script>
