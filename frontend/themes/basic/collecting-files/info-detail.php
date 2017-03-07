<?php
$this->registerCss("
 .info-detail .row{border-bottom:1px solid #ddd;}
     footer{display:none;}
");
if($model->marry==0){
    $marry = "单身";
}elseif($model->marry==1){
    $marry = "有女友";
} elseif($model->marry==2){
    $marry = "已婚";
}
?>

<div class="container info-detail">
    <?php if($model->status==1):?>
        <div class="row" style="padding: 10px;background-color: #fff;margin-bottom: 10px;">
            <a class="col-xs-12" style="color:green;">审核结果：待审核</a>
        </div>
    <div class="row" style="padding: 10px;background-color: #fff;margin-bottom: 10px;">
        <a class="col-xs-6 btn btn-default" style="color:green;" data-confirm="确认通过吗" href="/collecting-files/pass?id=<?=$model->id?>">审核通过</a>
        <a class="col-xs-6 btn btn-default" style="color:red;" data-confirm="确认不通过吗" href="/collecting-files/no-pass?id=<?=$model->id?>">审核不通过</a>
    </div>
    <?php else:
        $result = ($model->status==0)?"不通过":"通过"; ?>
        <div class="row" style="padding: 10px;background-color: #fff;margin-bottom: 10px;">
            <a class="col-xs-12" style="color:green;">审核结果：<?=$result?></a>
        </div>
    <?php endif;?>
    <div class="row" style="padding: 10px;background-color: #fff;">
        <div class="col-xs-6">会员编号：</div>
        <div class="col-xs-6"><?=$model->id?></div>
    </div>
    <div class="row" style="padding: 10px;background-color: #fff;">
        <div class="col-xs-6">微信号：</div>
        <div class="col-xs-6"><?=$model->weichat?></div>
    </div>
    <div class="row" style="padding: 10px;background-color: #fff;">
        <div class="col-xs-6">手机号：</div>
        <div class="col-xs-6"><?=$model->cellphone?></div>
    </div>
    <div class="row" style="padding: 10px;background-color: #fff;">
        <div class="col-xs-6">地址：</div>
        <div class="col-xs-6"><?=$model->address?></div>
    </div>
    <div class="row" style="padding: 10px;background-color: #fff;">
        <div class="col-xs-6">身高：</div>
        <div class="col-xs-6"><?=$model->height?>cm</div>
    </div>
    <div class="row" style="padding: 10px;background-color: #fff;">
        <div class="col-xs-6">体重：</div>
        <div class="col-xs-6"><?=$model->weight?>kg</div>
    </div>
    <div class="row" style="padding: 10px;background-color: #fff;">
        <div class="col-xs-6">婚姻情况：</div>
        <div class="col-xs-6"><?=$marry?></div>
    </div>
    <div class="row" style="padding: 10px;background-color: #fff;">
        <div class="col-xs-6">车型：</div>
        <div class="col-xs-6"><?=$model->car_type?></div>
    </div>
</div>

<?php foreach ($img as $item):?>
    <img class="img-responsive" src="<?=$item['img']?>">
<?php endforeach;?>
