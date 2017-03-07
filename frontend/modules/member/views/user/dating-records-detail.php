<?php

$extra = json_decode($model->extra,true);
$this->title = $extra['number'];
$time = 43200-(time()-$model->updated_at);

if(in_array($model->status,[9,10])){
    $status="客服处理中";$op="冻结";
}elseif($model->status==11){
    $status="推荐成功";$op="扣除";
}elseif($model->status==12){
    $status="推荐失败";$op="扣除";$op2="返还";
}

$this->registerCss("

.fail-reason,.fail-content{border-bottom: 1px solid #f3f3f3;background-color: #fff;padding:10px;}

.time-item{text-align:center;}

.time-item span {
    color:#F0478A;
    font-size:15px;
    margin-right:5px;
    border-radius:5px;
}

@media (min-width:768px){
    .fail-reason,.fail-content{text-align:center;}
}

");
?>
<div class="row member-center">
    <header>
        <div class="header">
            <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
            <h2 style="margin:0;"><?=$this->title?></h2>
            <?php if(!in_array($model->status,[9,10])):?>
                <a id="list_01" onclick="deleteR(<?=$model->id?>)" class="glyphicon glyphicon-trash"  style="right:3%;top:0;font-size:16px;line-height: 44px;position: absolute;"></a>
            <?php endif;?>
        </div>
    </header>
</div>
<script>
    function deleteR(id) {
        if(confirm('确认删除吗')){
            window.location.href = "dating-record-delete?id="+id;
        }
    }
</script>

<div class="row fail-content">
    <img style="width: 100px;border-radius: 5px;" class="img-responsive center-block" src="<?=$extra['avatar']?>">
    <h4 style="width: 50%;margin: 10px auto;text-align: center;font-weight: bold;"><?=$status?></h4>
    <?php if(in_array($model->status,[9,10])):?>
        <div class="time-item">
            <span id="day_show">0天</span>
            <span id="hour_show">00时</span>
            <span id="minute_show">00分</span>
            <span id="second_show">00秒后</span>
        </div>
        <div id="cui_cu_service" onclick="cuiCu();" class="btn btn-sm btn-success <?php if($time>0):?>disabled<?php endif;?>" style="width:80%;margin: 10px auto;display: block;font-size: 14px;padding: 3px 10px;">可催促客服处理</div>
    <?php endif;?>

    <?php if(in_array($model->status,[11])):?>
        <?php if($cc==1):?>
            <a id="evaluate" href="dating-records-evaluate?id=<?=$model->id?>" class="btn btn-sm btn-success" style="width: 80%;margin: 10px auto;display: block;font-size: 14px;padding: 3px 10px;">给予评价</a>
        <?php else:?>
            <div id="marke_friend" onclick="markeFriend();" class="btn btn-sm btn-success" style="width: 80%;margin: 10px auto;display: block;font-size: 14px;padding: 3px 10px;">
                已加为好友 ？
            </div>
            <div id="service_join" onclick="serviceJoin();" class="btn btn-sm btn-primary" style="width: 80%;margin: 10px auto;display: block;font-size: 14px;padding: 3px 10px;">
                <?php if($dd==1):?>客服介入处理中...<?php else:?>对方未加好友，要求客服介入？<?php endif;?>
            </div>
        <?php endif;?>
    <?php endif;?>
    <h6>地区：<?=$extra['address']?></h6>
    <h6>编号：<?=$extra['number']?></h6>
    <h6>妹子标签：<?=$extra['mark']?></h6>
    <h6>交友要求：<?=$extra['require']?></h6>
    <h6>节操币：<?=$op?><?=$model->number?>节操币<?php if($model->status==12):?>&nbsp;&nbsp; 返还<?=($extra['worth']-$model->number)?>节操币<?php endif;?></h6>
</div>

<?php if($model->status==12):?>
    <div class="row fail-reason">
        <h4>失败原因</h4>
        <p><?=$model->reason?></p>
    </div>
<?php elseif($model->status==11):?>
<div class="row fail-reason">
    <div class="btn btn-sm btn-default center-block" onclick="alert('女生微信名片已通过微信公众号推送到您的手机上,请注意查收');" style="display: block;width: 80%;"><img style="width: 14px;" src="/images/erweima.png"> 女生二维码</div>
</div>
<?php endif;?>

<?php

    $this->registerJs("
        timer({$time}); 
    ");

?>
<script type="text/javascript">

    function timer(intDiff) {

        if(intDiff>0){
            window.setInterval(function () {
                var day = 0,
                    hour = 0,
                    minute = 0,
                    second = 0; //时间默认值
                if (intDiff > 0) {
                    day = Math.floor(intDiff / (60 * 60 * 24));
                    hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                    minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                    second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
                }else {
                    $("#cui_cu_service").removeClass("disabled");
                }
                if (hour <= 9) hour = '0' + hour;
                if (minute <= 9) minute = '0' + minute;
                if (second <= 9) second = '0' + second;
                $('#day_show').html(day + "天");
                $('#hour_show').html('<s id="h"></s>' + hour + '时');
                $('#minute_show').html('<s></s>' + minute + '分');
                $('#second_show').html('<s></s>' + second + '秒后');
                intDiff--;
            }, 1000);
        }
    }


    function cuiCu() {

        if(confirm("是否确认催促客服处理？")){
            $.get("dating-records-cuicu?id=<?=$model->id?>",function(data){
                var jsonParse = $.parseJSON(data);
                if(jsonParse==1){
                    window.location.href = "service-join";return;
                }
                if(jsonParse=="ok"){
                    window.location.reload();
                }
                alert(jsonParse);
            });
        }
    }

    function markeFriend() {
        if(confirm("是否确认对方已添加你为好友？")){
            $.get("dating-records-makefriend?id=<?=$model->id?>",function(data){
                var jsonParse = $.parseJSON(data);
                if(jsonParse=="ok"){
                    window.location.reload();
                }
                alert(jsonParse);
            });
        }
    }

    function serviceJoin() {
        if(confirm("是否确认要求客服介入处理？")){
            $.get("dating-records-servicejoin?id=<?=$model->id?>",function(data){
                var jsonParse = $.parseJSON(data);
                if(jsonParse==1){
                    window.location.href = "service-join";return;
                }
                if(jsonParse=="ok"){
                    window.location.reload();
                }
                alert(jsonParse);
            });
        }
    }

</script>