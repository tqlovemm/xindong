<?php
    $this->title = "日期选择统计";
?>
<?=\yii\helpers\Html::a('总收入环比计算',['mom-an'],['class'=>'btn btn-success'])?>
<?=\yii\helpers\Html::a('分平台环比计算',['mom-an-detail'],['class'=>'btn btn-success'])?>
<div class="form-group row" style="margin-top: 10px;">
    <div class="col-md-4">
        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <select title="按天选择日期" id="end_time" name="end_time" class="form-control month_time">
                <?php foreach ($choice_time as $item):?>
                    <option value="<?=$item?>"><?=date('Y-m-d',$item)?></option>
                <?php endforeach;?>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <button class="btn btn-primary" id="submit_id" type="button" name="submit">查询</button>
        </div>
    </div>
</div>
<div class="contents box box-danger" style="width: 90%;padding:10px;">

</div>
<?php
$this->registerJs("
    $.get('mom-an-name?end_time='+$('#end_time').val(),function(data){
            $('.contents').html(data);
        });
    $('#submit_id').click(function(){
        $.get('mom-an-name?end_time='+$('#end_time').val(),function(data){
            $('.contents').html(data);
        });
    });
");
?>
<script>
    function calc(p,s,e) {
        $(".username").each(function(){
            var _this = $(this);
            var total = _this.children('.pa').html();
            var uid = $(this).attr('data-id');
            $.get('p?uid='+uid+'&s='+s+'&e='+e+'&t='+total,function (data) {
                _this.children('.'+p).html(data);
                $("#"+p).hide();
            })
        });
    }
</script>
