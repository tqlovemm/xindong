<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/10
 * Time: 14:06
 */

use yii\widgets\LinkPager;

$session = Yii::$app->session;
if(!$session->isActive){
    $session->open();
}
$this->title = "统计";
$this->registerCss('
    .container-fluid{padding:0}
    .vote-result{padding:10px;background-color:#fff;margin-top:10px;margin-bottom:10px;}
    .vote-result .col-xs-5,.vote-result .col-xs-7{padding:0;color:gray;}
    .vote-friend{padding:10px;background-color:#fff;border-bottom:1px solid #eee;}
    .vote-friend h5{margin:0;}
    .nav-tabs li{width:50%;}
    .nav-tabs{border:1px solid #eee;}
    .nav-tabs > li > a{margin:0;font-size:16px;color:#aaa;}
    .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus{ border:none;color:#E8437B;}
    .pagination > li > a, .pagination > li > span{padding:6px 8px !important;}

');
?>
<div class="row" style="background-color: #31313e;height: 40px;">
    <a href="javascript:history.go(-1);">
        <img src="/images/weixin/return.png" style="width: 20px;position: absolute;top: 10px;left: 10px;"></a>
    <h2 style="color: #fff;text-align: center;line-height: 40px;margin-top: 0;font-size: 18px;">
        <?=$this->title?>
    </h2>
    <a href="/test/new-year/join?id=<?=$session->get('id')?>" style="position: absolute;right:10px;top:10px;color:#fff;">参赛</a>
</div>
<div class="row" style="background-color: #fff;padding: 10px;margin-bottom: 10px;">
    <div class="col-xs-3" style="padding:0;">
        <?php if(!$img['thumb']):?>
        <img style="border-radius: 4px;max-width: 70px;"  class="img-responsive" src='/images/vote/47473585709842438.png'>
        <?php else:?>
        <img style="border-radius: 4px;max-width: 70px;" class="img-responsive" src='<?=$img['thumb']?>'>
        <?php endif;?>
    </div>
    <div class="col-xs-9" style="padding-right:0;">
        <h5 style="margin: 5px 0;color:gray;font-size: 16px;"> </h5>
            <?php if($info['status'] == 2 ):?>
            <p style="margin: 10px 0 0;color:gray;"><?=$info['enounce']?></p>
            <?php elseif($info['status'] == 2 && empty($info['enounce'])):?>
            <p style="margin: 10px 0 0;color:gray;">
                请告诉大家你的宣言吧！
            </p>
            <?php else:?>
            <p style="margin: 10px 0 0;color:gray;">
                您还没有参加报名投票或没有审核通过，所以暂时没有投票宣言哦。
            </p>
            <?php endif;?>
    </div>
</div>
<?php if($info['status'] == 2):?>
    <div class="row vote-result" style="margin-bottom: 0;border-bottom: 1px solid #eee;margin-left: 0px;">
        <div class="col-xs-7">总票数：<?= $info['num']?> 票</div>
        <div class="col-xs-5">当前排名：第 <?=$rank['rank']?> 名</div>
    </div>
    <div class="row vote-result" style="margin-top: 0;margin-left: 0px;">
        <div class="col-xs-7">距离前一名还差：<?=$rank['to']?> 票</div>
    </div>
<?php endif;?>
<ul id="myTab" class="nav nav-tabs row text-center" style="background-color: #fff;">
    <li class="active"><a href="#hetoyou" data-toggle="tab">谁为我投票</a></li>
    <li><a href="#youtohe" data-toggle="tab">我为谁投票</a></li>
</ul>
<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade in active" id="hetoyou">
            <?php if($getGood):
                foreach($getGood as $list)://var_dump($list['img']['thumb']);
                    if($list['da']['sex']==0){
                        $sex='906898231657870808.png';
                        $ta = "他";
                    }else{
                        $sex='23587436294114443.png';
                        $ta = "她";
                    }
            ?>
            <div class="row vote-friend">
                <div class="col-xs-2" style="padding: 0;">
                    <img style="border-radius: 4px;max-width: 70px;" class="img-responsive" src="<?php if(!$list['img']['thumb']){echo "/images/vote/129813819752096496.png";}else{ echo $list['img']['thumb'];}?>">
                </div>
                <div class="col-xs-10">
                    <h5 style="margin: 5px 0;color:gray;">  <img style="width: 18px;margin-top: -5px;" src="/images/vote/<?=$sex?> "></h5>
                    <h5 style="margin: 10px 0 0;color:gray;"><?=$list['da']['id']?>号 为我投了：1票</h5>
                </div>
            </div>


            <div class="text-center" style="margin-left: -20px;margin-right: -20px;">

            </div>

            <?php endforeach;else:?>

            <h2>暂无数据</h2>
            <?php endif;?>
    </div>
    <div class="tab-pane fade" id="youtohe">
                <?php if($sayGood):
                    foreach($sayGood as $item):
                        if($item['da2']['sex']==0){
                            $sex='906898231657870808.png';
                            $ta = "他";
                        }else{
                            $sex='23587436294114443.png';
                            $ta = "她";
                        }
                    ?>
                <div class="row vote-friend">
                    <div class="col-xs-2" style="padding: 0;">
                        <img style="border-radius: 4px;" class="img-responsive" src="<?=$item['img2']['thumb']?>">
                    </div>
                    <div class="col-xs-10">
                        <h5 style="margin: 5px 0;color:gray;">  <img style="width: 18px;margin-top: -5px;" src="/images/vote/<?=$sex?> "></h5>
                        <h5 style="margin: 10px 0 0;color:gray;">我为 <?=$item['da2']['id']?> 号 投了：1票</h5>
                    </div>
                </div>
                <?php endforeach;else:?>
            <h2 style="padding-left: 6px;">暂无数据</h2>
                <?php endif;?>
    </div>
</div>