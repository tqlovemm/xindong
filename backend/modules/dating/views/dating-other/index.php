<?php
use yii\widgets\LinkPager;
$this->registerCss("
    .col-md-1,.col-md-2{padding:0;}
    .full-ten .row{margin-bottom: 5px;background-color: #fff;padding:10px;}

");
?>
<div class="full-ten text-center">

    <div class="row">

        <div class="col-md-1">id</div>
        <div class="col-md-1">地区/编号</div>
        <div class="col-md-1">时间</div>
        <div class="col-md-1">头像</div>
        <div class="col-md-2">
            标签交友要求
        </div>

        <div class="col-md-1">价值</div>
        <div class="col-md-1">满十个时间</div>
        <div class="col-md-2">已过时间</div>
        <div class="col-md-2">操作</div>
    </div>
    <?php foreach ($models as $model):
        $time_floor = time()-$model['full_time'];
        ?>

        <div class="row">

            <div class="col-md-1"><?=$model['id']?></div>
            <div class="col-md-1"><?=$model['title']?><br><?=$model['number']?></div>
            <div class="col-md-1"><?=date('Y-m-d H:i:s',$model['updated_at'])?></div>
            <div class="col-md-1"><img class="img-responsive" style="width: 90px;" src="<?=$model['avatar']?>"></div>
            <div class="col-md-2">
                <h5><?=$model['content']?></h5>
                <h5><?=$model['url']?></h5>
            </div>
            <div class="col-md-1"><?=$model['worth']?>节操币</div>
            <div class="col-md-1"><?=date('Y/m/d H:i:s',$model['full_time'])?></div>
            <div class="col-md-2">
                <span>
                     满十已过<?=dataformat($time_floor)[0]?>
                </span>
               <br>
                <span style="color:red;">
                    建议 <?=dataformat($time_floor)[1]?>后重新开放报名
                </span>

            </div>
            <div class="col-md-2">
                <a class="btn btn-primary" href="/dating/dating-other/dating-back?like_id=<?=$model['number']?>">重新让会员报名</a>
            </div>

        </div>
    <?php endforeach;?>

</div>

<?= LinkPager::widget(['pagination' => $pages,]);?>
<?php

function dataformat($num) {

    $day = floor($num/86400);
    $hour = floor(($num-86400*$day)/3600);
    $minute = floor(($num-86400*$day-3600*$hour)/60);
    $time = $day.'天'.$hour.'时'.$minute.'分';
    $register = (6-$day)."天".(23-$hour)."时".(59-$minute).'分';

    return array(0=>$time,1=>$register);

}
