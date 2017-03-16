<?php

$extra = json_decode($model->extra,true);
$this->title = $extra['number'];
if(in_array($model->status,[9,10])){
    $status="等待中";$op="冻结";
}elseif($model->status==11){
    $status="成功";$op="扣除";
}elseif($model->status==12){
    $status="失败";$op="扣除";$op2="返还";
}
$pre_url = Yii::$app->params['shisangirl'];
$this->registerCss("

    .fail-reason,.fail-content{border-bottom: 1px solid #f3f3f3;background-color: #fff;padding:10px;}

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
    <img class="img-responsive center-block" src="<?=$pre_url.$extra['avatar']?>">
    <h5>地区：<?=$extra['address']?></h5>
    <h5>编号：<?=$extra['number']?></h5>
    <h5>妹子标签：<?=$extra['mark']?></h5>
    <h5>交友要求：<?=$extra['require']?></h5>
    <h5>交友结果：<?=$status?></h5>
    <h5>节操币：<?=$op?><?=$model->number?>节操币<?php if($model->status==12):?>&nbsp;&nbsp; 返还<?=($extra['worth']-$model->number)?>节操币<?php endif;?></h5>
</div>
<?php if($model->status==12):?>
    <div class="row fail-reason">
        <h4>失败原因</h4>
        <p><?=$model->reason?></p>
    </div>
<?php elseif($model->status==11):?>
    <h3>报名成功，请在微信公众号或客服号查看女生联系方式</h3>
<?php endif;?>
