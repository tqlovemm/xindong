<?php
    $this->title = "日期选择统计";
?>
<form action="choice-time" method="get">
    <div class="form-group row">
        <div class="col-md-2">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="date" class="form-control pull-right" name="start_time">
            </div>
        </div>
        <div class="col-md-2">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="date" class="form-control pull-right" name="end_time">
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <input class="btn btn-primary" type="submit" name="submit">
            </div>
        </div>
    </div>
</form>
<?php if(!empty($model)):$sum = 0; ?>
    <table class="table table-bordered" style="width: 60%;background-color: #fff;text-align: center;">
        <tr>
            <td colspan="3"><h3><?=date('Y-m-d',$start_time)?> - <?=date('Y-m-d',$end_time)?>销售收入明细表</h3></td>
        </tr>
    <?php foreach ($model as $key=>$item):
        $sum += $item['pa'];
        $query = \backend\modules\financial\models\FinancialWechatJoinRecord::find()->select("created_by,sum(payment_amount) as pas,count(created_by) as u_count")->where(['between','created_at',$start_time,$end_time])->andWhere(['platform'=>$item['platform']])->groupBy('created_by')->asArray()->all(); ?>
        <tr>
            <td style="vertical-align:middle;"><?=$item['platform']?></td>
            <td style="padding: 0;">
                <table class="table table-bordered" style="margin-bottom: 0;border: none;">
                    <?php foreach ($query as $list):
                        $user = \backend\models\User::findOne($list['created_by'])->username .' '.\backend\models\User::findOne($list['created_by'])->nickname;
                        ?>
                        <tr>
                            <td width="50%"><?=$user?></td>
                            <td><?=$list['pas']?></td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </td>
            <td style="vertical-align:middle;"><?=$item['pa']?></td>
        </tr>
    <?php endforeach;?>
        <tr><td colspan="2">总计</td><td style="background-color: yellow;"><?=$sum?></td></tr>
    </table>
<?php endif;?>
