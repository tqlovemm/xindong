<?php
$this->title = $area['title'].'妹子';
$time = time()-$contents['updated_at'];
$expire = $contents['expire']*3600;

$duration = ($contents['updated_at']+$expire-time())>0?($contents['updated_at']+$expire-time()):0;

$this->registerCss('

        ul.share-buttons{
          list-style: none;
          padding: 0;
        }

        ul.share-buttons li{
          display: inline;
        }
        .hear-img{margin: 10px;}
        .hear-list .row{margin: 0 -10px;}
        ol li{margin-bottom:15px;}
        .comment{display: inline-block;background-color: #DDD;padding:10px;width:100%;}
        .write-comment{margin: 0;padding:5px 15px;}
        .write-comment,
        .write-comment a{color:#ff1a10;}
        .gotop {
            background-image: url(../../../images/iconfont-fanhuidingbu.png);
            background-repeat: no-repeat;
            background-position: center center;
            background-size: 40px;
            height: 40px;
            width: 40px;
            position: fixed;
            right: 10px;
            bottom: 50px;
            z-index: 9999;
            cursor: pointer;
        }

        .time-item strong {
            background:#C71C60;
            color:#fff;
            line-height:49px;
            font-size:20px;
            font-family:Arial;
            padding:0 10px;
            margin-right:5px;
            border-radius:5px;
            box-shadow:1px 1px 3px rgba(0,0,0,0.2);
        }
        #day_show {

            line-height:49px;
            color:#c71c60;
            font-size:20px;
            margin:0 5px;
            font-family:Arial,Helvetica,sans-serif;
        }
        .item-title .unit {
            background:none;
            line-height:49px;
            font-size:24px;
            padding:0 10px;
            float:left;
        }
    ');

if(isset($_GET['top'])&&$_GET['top']=='bottoms'){

    $this->registerCss('
        nav,footer,.suo-xia{display:none;}
    ');
}

?>

<div class="container hear-list">
    <div class="row">
        <div class="col-md-10" style="padding: 0;">
            报名时间：<?=date('m/d H:i',$contents['updated_at'])?>—<?=date('m/d H:i',$contents['updated_at']+$expire)?>
            <div class="info-box">
                <div class="clearfix" style="padding: 10px;text-align: center;">
                    <div class="time-item">
                        <span id="day_show">0天</span>
                        <strong id="hour_show">0时</strong>
                        <strong id="minute_show">0分</strong>
                        <strong id="second_show">0秒</strong>
                    </div>
                    <?php if($time>$expire):?>
                        <a href="#" class="btn btn-default" disabled="true">报名已截止</a>
                    <?php else:?>
                        <a href="/wei-web/web?like_id=<?=$contents['number']?>" class="btn btn-danger">点击报名</a>
                    <?php endif;?>
                </div>

                <?php $mark = explode('，',$contents['url']);$friend = explode('，',$contents['content']);?>
                <div class="" style="color:#636363;padding: 10px;margin: 0 10px; font-size: 13px;background-color: #eaeaea;position: relative;">
                    <div class="">妹子编号：<?=$contents['number']?></div>
                    <div class="" style="margin: 10px 0;">妹子标签：
                        <?php foreach($friend as $item):?>
                            <span style="background-color: #ef4450;color:white;padding:2px 5px;border-radius: 4px;"><?=$item?></span>
                        <?php endforeach;?>
                    </div>
                    <div class="">交友要求：
                        <?php foreach($mark as $item):?>
                            <span style="background-color: #3e4b8d;color:white;padding:2px 5px;border-radius: 4px;"><?=$item?></span>
                        <?php endforeach;?>
                    </div>
                    <?php if(!empty($contents['introduction'])):?>
                    <div class="" style="margin-top: 5px;font-size: 14px;padding:5px 0;">
                        <span><?=$contents['introduction']?></span>
                    </div>
                    <?php endif;?>

                </div>
            </div>
            <?php foreach($photos['photos'] as $photo):?>
                <div class="hear-img">
                    <img class="img-responsive center-block" alt="<?=$photo['name']?>" title="<?=$photo['name']?>" src="<?=$photo['path']?>">
                </div>
            <?php endforeach;?>
        </div>

    </div>

    <div class="" style="background-color: #EF4450;border-radius: 5px;color:white;padding: 10px;margin-top: 10px;font-size: 16px;margin-bottom: 10px;">
        男生加微信客服：<?=Yii::$app->params['boy']?>,女生加：<?=Yii::$app->params['girl']?>
    </div>
</div>
<script type="text/javascript">

    var intDiff = parseInt(<?=$duration?>);//倒计时总秒数量

    function timer(intDiff){
        if(intDiff==0){

            return;
        }
        window.setInterval(function(){
            var day=0,
                hour=0,
                minute=0,
                second=0;//时间默认值
            if(intDiff >= 0){
                day = Math.floor(intDiff / (60 * 60 * 24));
                hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
            }else {

                return;
            }
            if (minute <= 9) minute = '0' + minute;
            if (second <= 9) second = '0' + second;
            $('#day_show').html(day+"天");
            $('#hour_show').html('<s id="h"></s>'+hour+'时');
            $('#minute_show').html('<s></s>'+minute+'分');
            $('#second_show').html('<s></s>'+second+'秒');
            intDiff--;
        }, 1000);
    }

    $(function(){
        timer(intDiff);
    });
</script>