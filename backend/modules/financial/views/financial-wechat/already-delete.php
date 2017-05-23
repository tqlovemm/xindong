<?php
\backend\modules\financial\FinancialAsset::register($this);
use yii\widgets\LinkPager;
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
    <?=\yii\helpers\Html::a('返还每日统计',['everyday-fee-record'],['class'=>'btn btn-success'])?>
</p>
<div class="today-fee-record-index row">
        <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">所有被删除</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
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
                    foreach ($model as $list):
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
                            <td><?=\yii\helpers\Html::a('恢复',['delete-record-back','id'=>$list['id']],[
                                'class'=>'btn-sm btn-danger',
                                    'data'=>[
                                        'confirm' => '确定恢复吗？',
                                        'method' => 'post',
                                ]])?></td>
                        </tr>
                    <?php endforeach;?>

                    <tr><td>当页总计</td><td style="background-color: yellow;"><?=$sum?></td></tr>
                    </tbody>
                </table>
            </div>
            <?= LinkPager::widget(['pagination' => $pages]); ?>
        </div>
    </div>
</div>