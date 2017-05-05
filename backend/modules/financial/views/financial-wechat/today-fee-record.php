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
    .table thead tr th{border:1px solid #fff;text-align:center;}
    .table tr td{border:1px solid #eee;text-align:center;}
    .follow{margin-bottom:0;}
    .follow li{list-style: none;}
    .info-box-content h4{color:gray;margin-top:5px;margin-bottom:5px;}
    a {color: #000;}
");
?>
<p>
    <?=\yii\helpers\Html::a('查看所有已删除记录',['already-delete'],['class'=>'btn btn-success'])?>
</p>
<div class="row">
    <a class="col-md-3 col-sm-6 col-xs-12" href="<?=Url::to(['everyday-fee-record'])?>">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>
            <div class="info-box-content">
                <h4>数量：<?=$q_1['count']?></h4>
                <span class="info-box-text">今日收款金额</span>
                <span class="info-box-number"><?=$q_1['sum']?></span>
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
                <h4>数量：<?=$q_3['count']?></h4>
                <span class="info-box-text">本周总收款</span>
                <span class="info-box-number"><?=$q_3['sum']?></span>
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
                <h4>数量：<?=$q_2['count']?></h4>
                <span class="info-box-text">本月收款</span>
                <span class="info-box-number"><?=$q_2['sum']?></span>
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
                <h4>选择月份进入</h4>
                <span class="info-box-text">其他月份收款</span>
                <span class="info-box-number">包含所有月份</span>
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
            $query = \backend\modules\financial\models\FinancialWechatJoinRecord::find()->where(['id'=>$ids])->andWhere(['status'=>1])->asArray()->all();
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
                        <th>收费金额</th>
                        <th>收费渠道</th>

                        <th>收费截图</th>
                        <th>会员编号</th>
                        <th>收款账号</th>
                        <th>收款人</th>
                        <th>时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sum = 0;
                    foreach ($query as $list):
                        $sum += $list['payment_amount'];
                        ?>
                        <tr>
                            <td><?=$list['vip']?></td>
                            <td><?=$list['payment_amount']?></td>
                            <td><?=$list['channel']?></td>

                            <td><a href="<?=Yii::$app->params['test'].$list['payment_screenshot']?>" data-lightbox="s" data-title="<?=$list['vip'].'__'.$list['number']?>">查看</a></td>
                            <td><?=$list['number']?></td>
                            <td><?=$list['payment_to']==1?'专用号':'客服号'?></td>
                            <td><?=\backend\models\User::findOne($list['created_by'])->nickname?></td>
                            <td><?=date('H:i',$list['created_at'])?></td>
                            <td><?=\yii\helpers\Html::a('无效',['delete-record','id'=>$list['id']],[
                                'class'=>'btn-sm btn-danger',
                                    'data'=>[
                                        'confirm' => '确定删除吗？删除后将无法恢复',
                                        'method' => 'post',
                                ]])?></td>
                        </tr>
                    <?php endforeach;?>
                    <tr><td>当日总计</td><td style="background-color: yellow;"><?=$sum?></td></tr>
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