<?php
$this->title = "信用额度";
$this->registerCss("
        .navbar{margin-bottom:0;}
        .credit-value{color:#fff;padding:10px;}
        .credit-value{background: -ms-linear-gradient(top, #0ea0be, #5abeb8);background:-moz-linear-gradient(top,#0ea0be,#5abeb8);background:-webkit-gradient(linear, 0% 0%, 0% 100%,from(#0ea0be), to(#5abeb8));background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#0ea0be), to(#5abeb8));background: -webkit-linear-gradient(top, #0ea0be, #5abeb8);background: -o-linear-gradient(top, #0ea0be, #5abeb8);}
        .credit-list{padding:10px;margin-bottom:10px;}
        .col-xs-1{line-height: 40px;font-size: 16px;padding:0;}
        #can {width: 100%;height: 500px;border: 0px solid #000;}
        @media (max-width:768px){#radar{width: 85%;margin:auto;}}
    ");


$creditAll = $credit['levels']+$credit['viscosity']+$credit['lan_skills']+$credit['sex_skills']+$credit['appearance'];
?>
<script type="text/javascript" src="/js/credit/chart.radar.js"></script>

<div class="row member-center">
    <header>
        <div class="header">
            <a href="javascript:history.back();"><span><img src="<?=Yii::getAlias('@web')?>/images/iconfont-fanhui.png"></span></a>
            <h2 style="margin:0;"><?=$this->title?></h2>
        </div>
    </header>
</div>
<div class="row credit-value">
    <h6 class="text-center">—— 信用度由五个维度综合评估而来 ——</h6>
    <canvas class="center-block" id="radar" height="370"></canvas>
</div>
<div class="row credit-list text-center" style="background-color: #fff;padding-bottom: 10px;">
    <div class="col-xs-6" style="border-right:1px solid gray;padding:5px;">
        <a href="#" data-confirm="暂未开放" style="color: #3cbea4;">
            <span class="glyphicon glyphicon-briefcase"></span>  信用管理
        </a>
    </div>
    <div class="col-xs-6" style="padding:5px;">
        <a href="#" data-confirm="暂未开放" style="color: #3cbea4;">
            <span class="glyphicon glyphicon-shopping-cart"></span>  信用生活
        </a>
    </div>
</div>
<script type="text/javascript">
    window.onload = function(){

        Radar.setOptions({
            element: 'radar',
            radius: 70,
            polar: [
                { text: '用户粘度', max: 190, icon: { sx: 0, sy: 0, w: 32, h: 33, l: -17, t: -60 } },
                { text: '外貌形象', max: 190, icon: { sx: 32, sy: 0, w: 30, h: 33, l: 30, t: -30 } },
                { text: '言谈技巧', max: 190, icon: { sx: 61, sy: 0, w: 32, h: 33, l: 10, t: 0 } },
                { text: '羞羞技能', max: 190, icon: { sx: 93, sy: 0, w: 31, h: 33, l: -40, t: 0 } },
                { text: '会员等级', max: 190, icon: { sx: 124, sy: 0, w: 29, h: 33, l: -50, t: -30 } }
            ],
            title: '{v}',
            data: [<?=$credit['viscosity']?>, <?=$credit['appearance']?>, <?=$credit['lan_skills']?>, <?=$credit['sex_skills']?>, <?=$credit['levels']?>],
            styles: {
                label: {
                    image: '/images/credit/icon.png'
                }
            }
        }).init();
    }
</script>

