<?php
$this->title = "续费页面";
$this->registerCss("
    .main-header,.main-footer{display:none;}
");

?>
<div class="box box-success" style="padding: 10px;">
    <?php if($reopen==0):
        $yearTime = date('Y-m-d',strtotime('+1 years',strtotime($model->expire)));
        $halfYearTime = date('Y-m-d',strtotime('+6 month', strtotime($model->expire)));
        $mouthTime = date('Y-m-d',strtotime('+1 month', strtotime($model->expire)));
        ?>
    <a href="renew?id=<?=$model->vid?>&type=10&expire=<?=$yearTime?>" data-confirm="确定年费续费吗？" class="info-box bg-yellow">
        <span class="info-box-icon"><i class="glyphicon glyphicon-king"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">到期时间：<?=$model->expire?></span>
            <span class="info-box-number">年费续费</span>
            <div class="progress">
                <div class="progress-bar" style="width: 50%"></div>
            </div>
            <span class="progress-description">续费后到期时间为：<?=$yearTime?></span>
        </div>
    </a>

    <a href="renew?id=<?=$model->vid?>&type=5&expire=<?=$halfYearTime?>" data-confirm="确定半年续费吗？" class="info-box bg-green">
        <span class="info-box-icon"><i class="glyphicon glyphicon-queen"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">到期时间：<?=$model->expire?></span>
            <span class="info-box-number">半年费续费</span>
            <div class="progress">
                <div class="progress-bar" style="width: 20%"></div>
            </div>
            <span class="progress-description">续费后到期时间为：<?=$halfYearTime?></span>
        </div>
    </a>

    <a href="renew?id=<?=$model->vid?>&type=1&expire=<?=$mouthTime?>" data-confirm="确定包月续费吗？" class="info-box bg-blue">
        <span class="info-box-icon"><i class="glyphicon glyphicon-pawn"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">到期时间：<?=$model->expire?></span>
            <span class="info-box-number">包月续费</span>
            <div class="progress">
                <div class="progress-bar" style="width: 20%"></div>
            </div>
            <span class="progress-description">续费后到期时间为：<?=$mouthTime?></span>
        </div>
    </a>
    <?php else:
        $yearTime = date('Y-m-d',strtotime('+1 years'));
        $halfYearTime = date('Y-m-d',strtotime('+6 month'));
        $mouthTime = date('Y-m-d',strtotime('+1 month'));
        ?>
        <a href="renew?id=<?=$model->vid?>&type=10&expire=<?=$yearTime?>&reopen=1" data-confirm="确定重新开通吗？" class="info-box bg-yellow">
            <span class="info-box-icon"><i class="glyphicon glyphicon-king"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">到期时间：<?=$model->expire?>，已经过期</span>
                <span class="info-box-number">年费重新开通</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 50%"></div>
                </div>
                <span class="progress-description">重新开通后到期时间为：<?=$yearTime?></span>
            </div>
        </a>

        <a href="renew?id=<?=$model->vid?>&type=5&expire=<?=$halfYearTime?>&reopen=1" data-confirm="确定重新开通吗？" class="info-box bg-green">
            <span class="info-box-icon"><i class="glyphicon glyphicon-queen"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">到期时间：<?=$model->expire?>，已经过期</span>
                <span class="info-box-number">半年费重新开通</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 20%"></div>
                </div>
                <span class="progress-description">重新开通后到期时间为：<?=$halfYearTime?></span>
            </div>
        </a>
        <a href="renew?id=<?=$model->vid?>&type=1&expire=<?=$mouthTime?>&reopen=1" data-confirm="确定重新开通吗？" class="info-box bg-blue">
            <span class="info-box-icon"><i class="glyphicon glyphicon-pawn"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">到期时间：<?=$model->expire?>，已经过期</span>
                <span class="info-box-number">包月重新开通</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 20%"></div>
                </div>
                <span class="progress-description">重新开通后到期时间为：<?=$mouthTime?></span>
            </div>
        </a>
    <?php endif;?>
</div>