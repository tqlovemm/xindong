<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/21
 * Time: 17:30
 */
?>
<div class="choice-mouth-index">
    <div class="row">
    <?php foreach ($model as $key=>$item):?>
            <!-- /.col -->
            <a href="<?=\yii\helpers\Url::to(['everyday-fee-record','week'=>$item['weekly_time']])?>" class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box <?php if($key==0):?>bg-yellow<?php else:?>bg-green<?php endif;?>">
                    <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">点击进入当周财务统计</span>
                        <span class="info-box-number"><?=date('Y年m月',$item['weekly_time'])?>第<?=weekNumber($item['weekly_time'])?>周</span>

                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                        <span class="progress-description">
                        <?=date('Y年第W周',$item['weekly_time'])?>：总计7天
                  </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </a>
    <?php endforeach;?>
    </div>
</div>
<?php

function weekNumber($timestamp = 'today') {
    return date("W", $timestamp) - date("W", strtotime(date("Y-m-01", $timestamp))) + 1;
}

?>