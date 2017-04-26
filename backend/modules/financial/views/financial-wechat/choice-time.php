<?php
    $this->title = "日期选择统计";
?>

<div class="form-group row">
    <div class="col-md-2">
        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="date" id="start_time" class="form-control pull-right" name="start_time">
        </div>
    </div>
    <div class="col-md-2">
        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="date" id="end_time" class="form-control pull-right" name="end_time">
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <button class="btn btn-primary" id="submit_id" type="button" name="submit">查询</button>
        </div>
    </div>
</div>
<div class="contents box box-danger" style="width: 60%;"></div>
<?php
$this->registerJs("
    var x = document.getElementById('start_time');
    var y = document.getElementById('end_time');
    x.setAttribute('value', '{$start_time}');
    y.setAttribute('value', '{$end_time}');

    $.get('choice-time?start_time='+$('#start_time').val()+'&end_time='+$('#end_time').val(),function(data){
            $('.contents').html(data);
    });

    $('#submit_id').click(function(){
        $.get('choice-time?start_time='+$('#start_time').val()+'&end_time='+$('#end_time').val(),function(data){
            $('.contents').html(data);
        });
    });
");
?>
