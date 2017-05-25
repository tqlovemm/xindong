<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;
$this->title = 'Male Info Texts';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCss("

.widget-user .widget-user-image{margin-left:-135px;}
.widget-user .widget-user-username{font-size:16px;}

");
?>
<div class="male-info-text-index">
    <div class="row">
        <?php foreach($model as $key=>$val):

            $user = \backend\models\User::findOne($val['user_id']);
            $userProfile = \frontend\models\UserProfile::findOne($val['user_id']);
            $avatar = $user->avatar;
            $number = $userProfile->number;
            $status = \common\components\Vip::sign_status($val['status']);
            $vip = \common\components\Vip::vip($user->groupid);
            ?>
            <!-- /.col -->
            <div class="col-md-4" style="color: gray;">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header <?=$status['color']?>">
                        <h3 class="widget-user-username">会员编号：<?=$number?></h3>
                        <h5 class="widget-user-desc">审核状态：<?=$status['status']?></h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" src="<?=$avatar?>?imageView2/1/w/90/h/90" alt="User Avatar">
                        <img class="img-circle" src="http://ooqyxp14h.bkt.clouddn.com/<?=$val['cover']['img_path']?>?imageView2/1/w/90/h/90" alt="User Avatar">
                        <img class="img-circle" src="http://ooqyxp14h.bkt.clouddn.com/<?=$val['zinfo']['weima']?>?imageView2/1/w/90/h/90" alt="User Avatar">
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">报名会员等级</h5>
                                    <span class="description-text"><?=$vip?></span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">消费心动币</h5>
                                    <span class="description-text"><?=$val['zinfo']['coin']?></span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">妹子专属编号</h5>
                                    <span class="description-text"><?=$val['zinfo']['zid']?></span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <div class="box-footer" style="padding-top:10px;">
                        <div class="row">
                            <div class="col-sm-6 border-right">
                                <h6>关于女孩：<?= $val['zinfo']['p_info']?></h6>
                                <h6>希望对象：<?= $val['zinfo']['h_info']?></h6>
                                <h6>已经报名人数：<?= $val['zinfo']['sign_up_count']?></h6>
                                <h6>发布时间：<?= date('Y-m-d H:i:s',$val['zinfo']['created_at'])?></h6>
                                <h6>女生地址：<?= $val['zinfo']['address']?> <?= $val['zinfo']['address_detail']?></h6>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">操作</h5><br>
                                    <div class="description-text">
                                        <a href="<?=Url::to(['signup-check','id'=>$val['sid'],'status'=>1])?>" class="btn btn-success">通过</a>
                                        <a href="<?=Url::to(['signup-check','id'=>$val['sid'],'status'=>2])?>" class="btn btn-warning">失败</a>
                                    </div>
                                </div>
                                <!-- /.description-block -->
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.widget-user -->
            </div>
        <?php endforeach;?>
    </div>
    <?= LinkPager::widget(['pagination' => $pages]); ?>
</div>
<script>
    function pushapp(content){

        var con = $(content);
        $.get('send-app?username='+con.attr('data-openid')+'&img='+con.attr('data-number'),function (data) {
            var result = $.parseJSON(data);
            alert(result.code);
        });
    }
</script>