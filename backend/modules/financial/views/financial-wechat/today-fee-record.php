<?php
\backend\modules\financial\FinancialAsset::register($this);
use yii\helpers\Url;
$wechat = Yii::$app->request->get('wechat');
$this->title = $wechat." 入会收款记录";
$this->registerCssFile('@web/js/lightbox/css/lightbox.css');
$this->registerJsFile('@web/js/lightbox/js/lightbox.min.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);

$week = strtotime('next sunday');
$mouth = mktime(0,0,0,date('m',time()),date('t'),date('Y',time()));

$this->registerCss("
    .table thead tr{background-color: #eee;}
    .table thead tr th{border:1px solid #eee;text-align:center;}
    .table tr td{border:1px solid #eee;text-align:center;}
    .follow{margin-bottom:0;}
    .follow li{list-style: none;}
    .info-box-content h4{color:gray;margin-top:5px;margin-bottom:5px;}
    a {color: #000;}
");
?>
<div class="row">
    <a class="col-md-3 col-sm-6 col-xs-12" href="<?=Url::to(['everyday-fee-record'])?>">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>
            <div class="info-box-content">
                <h4>数量：5</h4>
                <span class="info-box-text">今日收款金额</span>
                <span class="info-box-number">1,410</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </a>
    <!-- /.col -->
    <a class="col-md-3 col-sm-6 col-xs-12" href="<?=Url::to(['everyday-fee-record','week'=>$week])?>">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>

            <div class="info-box-content">
                <h4>数量：5</h4>
                <span class="info-box-text">本周总收款</span>
                <span class="info-box-number">410</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </a>
    <!-- /.col -->
    <a class="col-md-3 col-sm-6 col-xs-12" href="<?=Url::to(['everyday-fee-record','mouth'=>$mouth])?>">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>

            <div class="info-box-content">
                <h4>数量：5</h4>
                <span class="info-box-text">本月收款</span>
                <span class="info-box-number">13,648</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </a>
    <!-- /.col -->
    <a class="col-md-3 col-sm-6 col-xs-12" href="<?=Url::to(['choice-mouth'])?>">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>

            <div class="info-box-content">
                <h4>数量：5</h4>
                <span class="info-box-text">今年收款</span>
                <span class="info-box-number">93,139</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </a>
    <!-- /.col -->
</div>

<div class="today-fee-record-index row">
    <?php foreach ($model as $key=>$item):
            $ids = explode(',',$item['id']);
            $query = \backend\modules\financial\models\FinancialWechatJoinRecord::find()->where(['id'=>$ids])->asArray()->all();
        ?>
        <div class="col-md-6">
        <div class="box box-warning <?php if($key>6):?>collapsed-box<?php endif;?>">
            <div class="box-header with-border">
                <h3 class="box-title"><?=date('Y-m-d',$item['day_time']);?></h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered" style="margin-bottom: 10px;">
                    <thead>
                    <tr>
                        <th>收费类型</th>
                        <th>收费渠道</th>
                        <th>收费金额</th>
                        <th>收费截图</th>
                        <th>会员编号</th>
                        <th>收款账号</th>
                        <th>收款人</th>
                        <th>时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($query as $list):?>
                        <tr>
                            <td><?=$list['vip']?></td>
                            <td><?=$list['channel']?></td>
                            <td><?=$list['payment_amount']?></td>
                            <td><a href="<?=Yii::$app->params['test'].$list['payment_screenshot']?>" data-lightbox="s" data-title="<?=$list['vip'].'__'.$list['number']?>">查看</a></td>
                            <td><?=$list['number']?></td>
                            <td><?=$list['payment_to']==1?'收款专用号':'客服号'?></td>
                            <td><?=\backend\models\User::findOne($list['created_by'])->nickname .' _ '.\backend\models\User::findOne($list['created_by'])->username;?></td>
                            <td><?=date('H:i',$list['created_at'])?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
        <?php if($key%2==1):?>
          <div class="clearfix"></div>
        <?php endif;?>
    <?php endforeach;?>
</div>