<?php
$this->registerCss("
    .table{width:90%;}
    .table thead tr{background-color: #ddd;}
    .table thead tr th{border:1px solid #eee;text-align:center;}
    .table tr td{border:1px solid #eee;text-align:center;}
    .follow{margin-bottom:0;}
    .follow li{list-style: none;}

");
?>
<div class="today-record-index">

        <table class="table table-bordered">
                <caption>今日客服微信号人数统计</caption>
                <thead>
                <tr>
                        <th rowspan="2">微信号名称</th>
                        <th colspan="2">今日加入人数</th>
                        <th rowspan="2">总人数</th>
                        <th rowspan="2">今日删除人数</th>
                        <th rowspan="2">今日微信号零钱数</th>
                        <th rowspan="2">今日入会人数</th>
                        <th rowspan="2">入会率</th>

                        <th rowspan="2">创建人</th>
                        <th rowspan="2">数据统计</th>
                        <th rowspan="2">二维码</th>
                        <th rowspan="2">操作</th>
                </tr>
                <tr>
                        <th>男生</th>
                        <th>女生</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($model as $item):?>
                        <tr>
                                <td><?=$item['wechat']['wechat']?></td>
                                <td><?=$item['increase_boy_count']?></td>
                                <td><?=$item['increase_girl_count']?></td>
                                <td><?=$item['total_count']?></td>
                                <td><?=$item['reduce_count']?></td>
                                <td><?=$item['loose_change']?></td>
                                <td><?=$item['join_count']?></td>
                                <td><?=($item['join_count']/$item['increase_boy_count'])*100?>%</td>
                                <td><?=$item['created_by']?></td>
                                <td><a href="#" onclick="window.open('','','toolbar=no,status=0,location=no,resizable=yes,menubar=no,scrollbars=yes,top='+(window.screen.availHeight-600)/2+',left='+(window.screen.availWidth-1000)/2+',height=600,width=760')">查看</a></td>
                                <td><a data-lightbox="gg" data-title="" href="">查看二维码</a></td>
                                <td>删除</td>
                        </tr>
                <?php endforeach;?>
                </tbody>
        </table>
        <?php echo "<pre>";var_dump($model)?>

</div>
