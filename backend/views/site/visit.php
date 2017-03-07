<?php
use yii\web\View;
$this->registerJsFile("/js/jquery.js",['position' => View::POS_HEAD]);
?>
<a class="btn btn-success" href="http://www.cnzz.com/">具体访问量详情请点击</a>
<a class="btn btn-success" href="/index.php/site/cvisit">清空三天前数据</a>
<div class="clearfix"></div>
<script type="text/javascript">
    $(function () {
        $('#container').highcharts({
            chart: {
            },
            title: {
                text: '网站今日访问量'
            },
            //x轴
            xAxis: {
                categories:  [<?php for($i=0;$i<count($arr_hour);$i++){echo $arr_hour[$i].',';}?>]
            },
            tooltip: {
                formatter: function() {
                    var s;
                    if (this.point.name) { // the pie chart
                        s = ''+
                            this.point.name +': '+ this.y +' people';
                    } else {
                        s = ''+
                            this.x  +': '+ this.y;
                    }
                    return s;
                }
            },
            labels: {
                items: [{
                    html: 'Total visit today',
                    style: {
                        left: '40px',
                        top: '8px',
                        color: 'black'
                    }
                }]
            },
            series: [{
                type: 'spline',
                name: 'today',
                data: [<?php for($i=0;$i<count($arr_count);$i++){echo $arr_count[$i].',';}?>]
            } /*{
                type: 'column',
                name: 'today',
                data: [],
            }, {
                type: 'column',
                name: 'Joe',
                data: [4, 3, 3, 9, 0,5,4, 3, 3, 9, 0,5,4, 3, 3, 9, 0,5,4, 3, 3, 9, 0,5]
            }, {
                type: 'spline',
                name: 'Average',
                data: [3, 2.67, 3],
                marker: {
                    lineWidth: 2,
                    lineColor: Highcharts.getOptions().colors[3],
                    fillColor: 'white'
                }
            }, */,{
                type: 'pie',
                name: 'Total consumption',
                data: [{
                    name: '今天',
                    y: <?=$today?>,
                    color: Highcharts.getOptions().colors[0] // Jane's color
                }, {
                    name: '昨天',
                    y: <?=$yesterday?>,
                    color: Highcharts.getOptions().colors[1] // John's color
                }, {
                    name: '前天',
                    y: <?=$beforeYesterday?>,
                    color: Highcharts.getOptions().colors[2] // Joe's color
                }],
                center: [170, 20],
                size: 100,
                showInLegend: false,
                dataLabels: {
                    enabled: false
                }
            }]
        });
    });
</script>
<div id="container" style="width:1000px;height:500px;margin:0 auto"></div>
