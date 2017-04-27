<?php
$this->title = "客服微信号人数统计";
$this->registerCssFile('@web/js/lightbox/css/lightbox.css');
$this->registerJsFile('@web/js/lightbox/js/lightbox.min.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);
$this->registerCss("
    .table thead tr{background-color: #eee;}
    .table thead tr th{border:1px solid #fff;text-align:center;vertical-align: middle;}
    .table tr td{border:1px solid #eee;text-align:center;}
    .follow{margin-bottom:0;}
    .follow li{list-style: none;}
");
?>
<div class="" style="width: 20%;margin-bottom: 10px;">
<select class="form-control" id="past_join">
        <?php foreach ($day_times as $day_time):?>
        <option value="<?=$day_time?>"><?=date('Y-m-d',$day_time)?></option>
        <?php endforeach;?>
</select>
</div>
<div class="today-record-index contents"></div>
<?php
$this->registerJs("

        $.get('td?day_time='+$('#past_join').val(),function(data){
                $('.contents').html(data);
        });
        $('#past_join').change(function(){
                $.get('td?day_time='+$('#past_join').val(),function(data){
                        $('.contents').html(data);
                });
        });
");
?>