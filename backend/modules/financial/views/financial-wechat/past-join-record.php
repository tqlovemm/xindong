<?php
$wechat = Yii::$app->request->get('wechat');
$this->title = $wechat." 每日人数统计";
$this->registerCss("
    .table thead tr{background-color: #ddd;}
    .table thead tr th{border:1px solid #eee;text-align:center;}
    .table tr td{border:1px solid #eee;text-align:center;}
    .follow{margin-bottom:0;}
    .follow li{list-style: none;}
    .main-header,.main-sidebar{display:none;}
    .content-wrapper{margin-left:0;}
");
?>
<div class="today-record-index">
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
                                $screenshot = "<a href='#' onclick=\"window.open('{$imgPath}','','toolbar=no,status=0,location=no,resizable=yes,menubar=no,scrollbars=yes,top='+(window.screen.availHeight-600)/2+',left='+(window.screen.availWidth-1000)/2+',height=560,width=560')\">截图</a>";
                        }

                        $joinCount = "";
                        if($item['join_count']){
                                $joinCount = "<a href='#' onclick=\"window.open('day-fee-record?time=$item[day_time]&wechat_id=$item[wechat_id]','','toolbar=no,status=0,location=no,resizable=yes,menubar=no,scrollbars=yes,top='+(window.screen.availHeight-800)/2+',left='+(window.screen.availWidth-1000)/2+',height=700,width=760')\">截图</a>";
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
