<?php
    $this->title = "日期选择统计";
?>
<div class="row">
    <a href="mom-an-detail" class="col-md-3 col-sm-6 col-xs-12" style="color: #000;">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Sub platform</span>
                <span class="info-box-number">分平台环比计算</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </a>
    <!-- /.col -->
    <a href="mom-an-name" class="col-md-3 col-sm-6 col-xs-12" style="color: #000;">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Split customer service</span>
                <span class="info-box-number">分客服环比计算</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </a>
    <!-- /.col -->
    <a href="mom-an" class="col-md-3 col-sm-6 col-xs-12" style="color: #000;">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total revenue</span>
                <span class="info-box-number">总收入环比计算</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </a>
</div>
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
                $("#"+p+"s").show();
            })
        });
    }
</script>
