<?php
$wechat = Yii::$app->request->get('wechat');
$this->title = $wechat." 每日人数统计";
$this->registerCssFile('@web/js/lightbox/css/lightbox.css');
$this->registerJsFile('@web/js/lightbox/js/lightbox.min.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);
$this->registerCss("
    .table thead tr{background-color: #ddd;}
    .table thead tr th{border:1px solid #fff;text-align:center;vertical-align: middle;}
    .table tr td{border:1px solid #eee;text-align:center;}
    .follow{margin-bottom:0;}
    .follow li{list-style: none;}
");
$percent = ($total['tc']==0)?0:round(($total['jc']/$total['tc']),4)*100;
?>
<div class="today-record-index" style="width: 70%">
        <div class="box box-success">
                <div class="box-header with-border">
                        <h3 class="box-title">总计</h3>
                        <div class="box-tools pull-right"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button></div>
                </div>
                <div class="box-body">
                        <table class="table table-bordered" style="margin-bottom: 10px;">
                <thead>
                <tr style="background-color: #fff7ee;">
                        <th>总计</th>
                        <th>加入总数</th>
                        <th>全部总数</th>
                        <th>入会总数</th>
                        <th>总入会率</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                        <td>从 <?=date('Y-m-d',$total['dt_min'])?> 到 <?=date('Y-m-d',$total['dt_max'])?></td>
                        <td><?=$total['tc']?></td>
                        <td><?=$total['mc']?></td>
                        <td><?=$total['jc']?></td>
                        <td><?=$percent?>%</td>
                </tr>
                </tbody>
        </table>
                </div>
        </div>
        <br>
        <div class="box box-warning">
                <div class="box-header with-border">
                        <h3 class="box-title">每日统计</h3>
                        <div class="box-tools pull-right"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button></div>
                </div>
                <div class="box-body">
                        <table class="table table-bordered">
                <thead>
                        <tr>
                                <th rowspan="2">时间</th>
                                <th colspan="2">加入人数</th>
                                <th rowspan="2">总人数</th>
                                <th rowspan="2">删除人数</th>
                                <th rowspan="2">微信零钱</th>
                                <th rowspan="2">入会数</th>
                                <th rowspan="2">入会率</th>
                                <th rowspan="2">创建人</th>
                                <th rowspan="2">创建时间</th>
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
                        $user = \backend\models\User::findOne($item['created_by'])->username .' '.\backend\models\User::findOne($item['created_by'])->nickname;
                        if(!empty($item['wechat_loose_change_screenshot'])){
                                $imgPath = Yii::$app->params['test'].$item['wechat_loose_change_screenshot'];
                                $screenshot = "<a href='$imgPath' data-title='s' data-lightbox='s'>截图</a>";
                        }

                        $joinCount = "";
                        if($item['join_count']){
                                $joinCount = "<a href='#' onclick=\"window.open('day-fee-record?time=$item[day_time]&wechat_id=$item[wechat_id]&wechat=$wechat','','toolbar=no,status=0,location=no,resizable=yes,menubar=no,scrollbars=yes,top='+(window.screen.availHeight-800)/2+',left='+(window.screen.availWidth-1000)/2+',height=700,width=900')\">截图</a>";
                        }
                        ?>
                        <tr>
                                <td><?=date('Y/m/d',$item['day_time'])?></td>
                                <td><?=$item['increase_boy_count']?></td>
                                <td><?=$item['increase_girl_count']?></td>
                                <td><?=$item['total_count']?></td>
                                <td><?=$item['reduce_count']?></td>
                                <td><?=$item['loose_change']?> <?=$screenshot?></td>
                                <td><?=$item['join_count']?> <?=$joinCount?></td>
                                <td><?=$percent?>%</td>
                                <td><?=$user?></td>
                                <td><?=date('Y/m/d H:i',$item['created_at'])?></td>
                        </tr>
                <?php endforeach;?>
                </tbody>
        </table>
                </div>
        </div>
</div>
