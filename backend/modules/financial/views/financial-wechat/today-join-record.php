<?php
$this->title = date('Y-m-d',strtotime('yesterday'))." 客服微信号人数统计";
$this->registerCssFile('@web/js/lightbox/css/lightbox.css');
$this->registerJsFile('@web/js/lightbox/js/lightbox.min.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);
$this->registerCss("
    .table thead tr{background-color: #eee;}
    .table thead tr th{border:1px solid #eee;text-align:center;}
    .table tr td{border:1px solid #eee;text-align:center;}
    .follow{margin-bottom:0;}
    .follow li{list-style: none;}
");
?>
<div class="today-record-index">
        <div class="box box-success">
                <div class="box-header with-border">
                        <h3 class="box-title"><?=$this->title ?></h3>
                        <div class="box-tools pull-right"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button></div>
                </div>
                <div class="box-body">
                        <table class="table table-bordered">
                <caption><?=$this->title?></caption>
                <thead>
                        <tr>
                                <th rowspan="2">微信号名称</th>
                                <th colspan="2">今日加入人数</th>
                                <th rowspan="2">总人数</th>
                                <th rowspan="2">今日删除人数</th>
                                <th rowspan="2">今日微信号零钱数</th>
                                <th rowspan="2">今日入会人数</th>
                                <th rowspan="2">今日入会率</th>
                                <th rowspan="2">创建人</th>
                                <th rowspan="2">往日统计</th>
                                <th rowspan="2">操作</th>
                        </tr>
                        <tr>
                                <th>男生</th>
                                <th>女生</th>
                        </tr>
                </thead>
                <tbody>
                <?php foreach ($model as $item):
                        $percent = ($item['increase_boy_count']==0)?0:round(($item['join_count']/$item['increase_boy_count']),4)*100;
                        $screenshot = "";
                        $user = \backend\models\User::findOne($item['created_by'])->username .'：'.\backend\models\User::findOne($item['created_by'])->nickname;
                        if(!empty($item['wechat_loose_change_screenshot'])){
                                $imgPath = Yii::$app->params['test'].$item['wechat_loose_change_screenshot'];
                                $screenshot = "<a href='$imgPath' data-lightbox='s' data-title='s'>零钱截图</a>";
                        }
                        ?>
                        <tr>
                                <td><?=$item['wechat']['wechat']?></td>
                                <td><?=$item['increase_boy_count']?></td>
                                <td><?=$item['increase_girl_count']?></td>
                                <td><?=$item['total_count']?></td>
                                <td><?=$item['reduce_count']?></td>
                                <td><?=$item['loose_change']?> — <?=$screenshot?></td>
                                <td><?=$item['join_count']?></td>
                                <td><?=$percent?>%</td>
                                <td><?=$user?></td>
                                <td>
                                        <a target='_blank' href="past-join-record?wechat_id=<?=$item['wechat_id']?>&wechat=<?=$item['wechat']['wechat']?>">查看</a>
                                </td>
                                <td>删除</td>
                        </tr>
                <?php endforeach;?>
                </tbody>
        </table>
                </div>
        </div>
</div>
