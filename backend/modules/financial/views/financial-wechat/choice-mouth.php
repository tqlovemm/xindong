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
    <?php foreach ($model as $key=>$item):
        $url = ($type==null)?\yii\helpers\Url::to(['everyday-fee-record','mouth'=>$item['mouth_time']]):\yii\helpers\Url::to(['choice-week','mouth'=>$item['mouth_time']]);
        ?>
            <!-- /.col -->
            <a href="<?=$url?>" class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box <?php if($key==0):?>bg-yellow<?php else:?>bg-green<?php endif;?>">
                    <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">点击进入当月财务统计</span>
                        <span class="info-box-number"><?=date('Y年m月份',$item['mouth_time'])?></span>

                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                        <span class="progress-description">
                        总计<?=date('d',$item['mouth_time'])?> 天
                  </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </a>
    <?php endforeach;?>
    </div>
</div>
