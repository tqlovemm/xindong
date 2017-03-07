<?php

    $this->title = "信用额度";
    $this->registerCss("
        .credit{background: -ms-linear-gradient(top, #0ea0be, #5abeb8);background:-moz-linear-gradient(top,#0ea0be,#5abeb8);background:-webkit-gradient(linear, 0% 0%, 0% 100%,from(#0ea0be), to(#5abeb8));background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#0ea0be), to(#5abeb8));background: -webkit-linear-gradient(top, #0ea0be, #5abeb8);background: -o-linear-gradient(top, #0ea0be, #5abeb8);padding-bottom:30px;}
        .navbar{margin-bottom:0;}
        .credit-value{padding:10px;color:#fff;padding-bottom: 0;}
        .credit-value a{color:#fff;}
        .credit-value .credit-intro{width: 60px;margin: auto;height: 60px;line-height: 60px;border-radius: 50%;background-color: #53bdbe;}
        .credit-value .credit-intro-icon{font-size: 24px;}
        .col-xs-1{line-height: 40px;font-size: 16px;padding:0;}
        @media (max-width:768px){#meter{width: 84%;margin: auto;}}
    ");

?>
<div class="credit">
    <div class="row credit-value">
        <h5 class="text-center">—— 因为信用所有相信 ——</h5>
        <br>
        <canvas class="center-block" id="meter" height="250"></canvas>
    </div>
    <div class="row credit-value text-center">
        <div class="col-xs-6">
            <a href="/member-ship/credit-intro">
                <div class="credit-intro">
                    <div class="credit-intro-icon">
                        <span class="glyphicon glyphicon-random"></span>
                    </div>
                </div>
                <h5>信用解读</h5>
            </a>
        </div>
        <div class="col-xs-6">
            <a href="#">
                <div class="" style="width: 60px;margin: auto;height: 60px;line-height: 60px;border-radius: 50%;background-color: #53bdbe">
                    <div class="" style="font-size: 24px;">
                        <span class="glyphicon glyphicon-plane"></span>
                    </div>
                </div>
                <h5>信用提升</h5>
            </a>
        </div>
    </div>
</div>
<div class="row credit-value text-center" style="background-color: #fff;padding-bottom: 10px;">
    <div class="col-xs-6" style="border-right:1px solid gray;padding:5px;">
        <a href="#" style="color: #3cbea4;">
            <span class="glyphicon glyphicon-briefcase"></span>  信用管理
        </a>
    </div>
    <div class="col-xs-6" style="padding:5px;">
        <a href="#" style="color: #3cbea4;">
            <span class="glyphicon glyphicon-shopping-cart"></span>  信用生活
        </a>
    </div>
</div>

<script type="text/javascript" src="/js/credit/chart.meter.js"></script>
<script type="text/javascript">
    window.onload = function(){
        Meter.setOptions({
            element: 'meter',
            centerPoint: {
                x: 150,
                y: 150
            },
            radius: 120,
            data: {
                value: <?=$credit?>,
                title: '信用{t}',
                subTitle: '评估时间：<?=date('Y-m-d')?>',
                area: [{
                    min: 350, max: 550, text: '极差'
                },{
                    min: 550, max: 600, text: '中等'
                },{
                    min: 600, max: 650, text: '良好'
                },{
                    min: 650, max: 700, text: '优秀'
                },{
                    min: 700, max: 950, text: '极好'
                }]
            }
        }).init();
    }
</script>
