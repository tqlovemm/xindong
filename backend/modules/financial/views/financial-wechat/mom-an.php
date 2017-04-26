<?php
$this->title = "环比同比统计";
$percent01 = ($model_this['sum']==0)?0:round(($model_this['sum']-$model_last['sum'])/$model_this['sum'],4)*100;
$percent02 = ($model_past['sum']==0)?0:round(($model_past['sum']-$model_past['sum'])/$model_past['sum'],4)*100;

?>

<div class="box box-success" style="background-color: #fff;width: 50%;text-align: center;padding:10px;">
    <table class="table table-bordered">
        <caption>今日统计</caption>
        <tr>
            <td rowspan="2" style="vertical-align: middle">总收入</td>
            <td><?=date('Y年m月d',$last_start_time).'-'.date('d日',$last_end_time)?></td>
            <td><?=date('Y年m月d',$this_start_time).'-'.date('d日',$this_end_time)?></td>
            <td><?=date('Y年m月d',$past_start_time).'-'.date('d日',$past_end_time)?></td>
            <td>环比<?php if($percent01>=0){echo "增长";}else{echo "降低";}?></td>
            <td>同比<?php if($percent02>=0){echo "增长";}else{echo "降低";}?></td>
        </tr>
        <tr><td style="background-color: yellow;"><?=$model_last['sum']?></td><td style="background-color: yellow;"><?=$model_this['sum']?></td><td style="background-color: yellow;"><?=$model_past['sum']?></td><td><?=$percent01?>%</td><td><?=$percent02?>%</td></tr>
    </table>
</div>
<div class="box box-danger" style="width: 50%;background-color: #fff;">
    <div class="clearfix" style="margin: 10px 0;">
        <form class="col-md-6">
            <label for="day_time">按天选择日期</label>
            <select title="按天选择日期" id="day_time" name="month" class="form-control month_time">
                <?php foreach ($model_1 as $item):?>
                    <option value="<?=$item?>"><?=date('Y-m-d',$item)?></option>
                <?php endforeach;?>
            </select>
        </form>
        <form class="col-md-6">
            <label for="month_time">按月选择日期</label>
            <select title="按天选择日期" id="month_time" name="month" class="form-control month_time">
                <option value="">请选择日期</option>
                <?php foreach ($model_2 as $item):?>
                    <option value="<?=$item?>"><?=date('Y-m',$item)?></option>
                <?php endforeach;?>
            </select>
        </form>
    </div>
    <div class="contents" style="text-align: center;padding:10px;"></div>
</div>

<?php
$this->registerJs("
  $('.month_time',this).change(function () {
        $.get('d?date='+$(this).val(),function(data){
            $('.contents').html(data);
        });
    });
    
    $.get('d?date='+$('.month_time').val(),function(data){
            $('.contents').html(data);
        });
");
?>
