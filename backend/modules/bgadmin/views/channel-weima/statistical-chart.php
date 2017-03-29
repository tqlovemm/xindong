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
                        $time = date('d',$item['created_at']);
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
                type: 'column',
                name: '当日关注',
                data: [<?php foreach ($model as $item){
                    $time = $item['ns'];
                    echo $time.',';
                }?>]
            }, {
                type: 'column',
                name: '当日取关',
                data: [<?php foreach ($model as $item){
                    $time = $item['us'];
                    echo $time.",";
                }?>]
            }, {
                type: 'column',
                name: '新用户关注',
                data: [<?php foreach ($model as $item){
                    $time = $item['nns'];
                    echo $time.',';
                }?>]
            }, {
                type: 'spline',
                name: '净增长',
                data: [<?php foreach ($model as $item){
                    $time = $item['alls'];
                    echo $time.',';
                }?>],
                marker: {
                    lineWidth: 2,
                    lineColor: Highcharts.getOptions().colors[3],
                    fillColor: 'white'
                }
            }, {
                type: 'pie',
                name: 'Total consumption',
                data: [{
                    name: '总关注',
                    y: <?php
                    $sum_1 = 0;
                    foreach ($model as $item){
                        $sum_1+=(int)$item['ns'];
                        }echo $sum_1;?>,
                    color: Highcharts.getOptions().colors[0] // Jane's color
                }, {
                    name: '总取关',
                    y: <?php
                    $sum_4 = 0;
                    foreach ($model as $item){
                        $sum_4+=(int)$item['us'];
                        }echo $sum_4;?>,
                    color: Highcharts.getOptions().colors[1] // John's color
                }, {
                    name: '新关注',
                    y: <?php
                    $sum_3 = 0;
                    foreach ($model as $item){
                        $sum_3+=(int)$item['nns'];
                        }echo $sum_3;?>,
                    color: Highcharts.getOptions().colors[2] // Joe's color
                }],
                center: [100, 80],
                size: 100,
                showInLegend: false,
                dataLabels: {
                    enabled: false
                }
            }]
        });
    });
</script>

<div id="container" style="width:100%;height:800px;margin:0 auto"></div>