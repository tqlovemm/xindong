<?php

if($fire_status==0){
    $status="等待中";$op="冻结";
}elseif($fire_status==1){
    $status="成功";$op="扣除";
}elseif($fire_status==2){
    $status="失败";$op="返还";
}

$this->registerCss("

    .fail-reason,.fail-content{border-bottom: 1px solid #f3f3f3;background-color: #fff;padding:10px;}

    @media (min-width:768px){

        .fail-reason,.fail-content{text-align:center;}

    }
");
$pre_url = Yii::$app->params['threadimg'];
$avatar = str_replace('http://www.13loveme.com:82/',$pre_url,$model->pic_path);
?>

<div class="row member-center">
    <header>
        <div class="header">
            <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
            <h2 style="margin:0;"><?=$this->title?></h2>
                <?php if($fire_status != 0):?>
                <a id="list_01" onclick="deleteR(<?=$id?>)" class="glyphicon glyphicon-trash"  style="right:3%;top:0;font-size:16px;line-height: 44px;position: absolute;"></a>
                <?php endif;?>
        </div>
    </header>
</div>
<script>

    function deleteR(id) {

        if(confirm('确认删除吗')){
            window.location.href = "firefighter-delete?id="+id;
        }
    }

</script>

<div class="row fail-content">
    <img class="img-responsive center-block" src="<?=$avatar?>">
    <h5>地区：<?=$model->name?></h5>
    <h5>交友要求：<?=$model->content?></h5>
    <h5>交友结果：<?=$status?></h5>
    <h5>节操币： <?=$op;?> <?=$model->coin?> 节操币</h5>
</div>
<?php if($fire_status == 2):?>
<div class="row fail-reason">
    <h4>失败原因：</h4>
    <p style="color: orange"><?=$reason?></p>
</div>
<?php elseif($fire_status == 1):?>
    <h3>报名成功，请在微信公众号或客服号查看女生联系方式</h3>
<?php endif;?>
