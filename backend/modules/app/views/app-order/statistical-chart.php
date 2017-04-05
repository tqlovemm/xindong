<?php
use yii\helpers\Html;
$this->title = "app节操币消费统计";
?>
<p>
    <?= Html::a('会员充值统计', ['static'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('图形统计', ['statistical-chart'], ['class' => 'btn btn-success']) ?>
</p>
<script type="text/javascript" src="/js/highcharts.js"></script>
<script type="text/javascript" src="/js/exporting.js"></script>
<script type="text/javascript">
    $(function () {
        $('#container').highcharts({
            chart: {
            },
            title: {
                text: '折线，饼状，条状综合图'
            },
            //x轴
            xAxis: {
                categories: [
                    <?php foreach ($model as $item){
                        $time = date('d',$item['c']);
                        echo $time;
                        echo ",";
                    }?>
                ]
            },
            tooltip: {
                formatter: function() {
                    var s;
                    if (this.point.name) { // the pie chart
                        s = ''+
                            this.point.name +': '+ this.y +' fruits';
                    } else {
                        s = ''+
                            this.x  +': '+ this.y;
                    }
                    return s;
                }
            },
            labels: {
                items: [{
                    html: '渠道二维码图形统计',
                    style: {
                        left: '40px',
                        top: '8px',
                        color: 'black'
                    }
                }]
            },
            series: [{
                type: 'spline',
                name: '净增长',
                data: [<?php foreach ($model as $item){
                    $time = $item['t'];
                    echo $time.',';
                }?>],
                marker: {
                    lineWidth: 2,
                    lineColor: Highcharts.getOptions().colors[3],
                    fillColor: 'white'
                }
            }]
        });
    });
</script>

<div id="container" style="width:100%;height:500px;margin:0 auto"></div>