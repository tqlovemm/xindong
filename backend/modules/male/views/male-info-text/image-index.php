<?php
use yii\widgets\LinkPager;
$this->title = 'Male Info Texts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="male-info-text-index">
    <div class="row">
    <?php foreach($model as $key=>$val):
        $avatar = $val->avatar;
        $status = \common\components\Vip::status($val['status']);
        ?>
            <!-- /.col -->
            <a class="col-md-4" href="" style="color: inherit;">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header <?=$status['color']?>">
                        <h3 class="widget-user-username">会员编号：<?=$val['id']?></h3>
                        <h5 class="widget-user-desc">审核状态：<?=$status['status']?></h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" src="http://ooqyxp14h.bkt.clouddn.com/<?=$avatar['img']?>?imageView2/1/w/100/h/100" alt="User Avatar">
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">等级</h5>
                                    <span class="description-text"><?=\common\components\Vip::vip($val['vip'])?></span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">节操币</h5>
                                    <span class="description-text"><?=$val['coin']?></span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">入会地区</h5>
                                    <span class="description-text"><?=$val['province']?></span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
                <!-- /.widget-user -->
            </a>
    <?php endforeach;?>
    </div>
    <?= LinkPager::widget(['pagination' => $pages]); ?>
</div>
