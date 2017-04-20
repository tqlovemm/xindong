<?php
    use yii\helpers\Url;
?>
<div class="row">
    <div class="col-lg-3 col-md-4 col-sm-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>1</h3>
                <p>会员入会</p>
            </div>
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <a href="<?=Url::to(['financial-wechat-join-record/create','wechat_id'=>$wechat_id,'type'=>1])?>" class="small-box-footer">
                Enter item <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-md-4 col-sm-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>2</h3>
                <p>会员升级</p>
            </div>
            <div class="icon">
                <i class="fa fa-plane"></i>
            </div>
            <a href="<?=Url::to(['financial-wechat-join-record/create','wechat_id'=>$wechat_id,'type'=>2])?>" class="small-box-footer">
                Enter item <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-md-4 col-sm-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>3</h3>
                <p>其他收款</p>
            </div>
            <div class="icon">
                <i class="fa fa-umbrella"></i>
            </div>
            <a href="<?=Url::to(['financial-wechat-join-record/create','wechat_id'=>$wechat_id,'type'=>3])?>" class="small-box-footer">
                Enter item <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-md-4 col-sm-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>4</h3>
                <p>入会统计</p>
            </div>
            <div class="icon">
                <i class="fa fa-chain-broken"></i>
            </div>
            <a href="#" class="small-box-footer">
                Enter item <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
</div>
<div class="row">
    <div class="col-md-6">
        <?php if($type==1){
            echo $this->render('create_1', [
                'model' => $model,'province'=>$province,'wechat_id'=>$wechat_id,'type'=>$type
            ]);
        }elseif($type==2){
            echo $this->render('create_2', [
                'model' => $model,'province'=>$province,'wechat_id'=>$wechat_id,'type'=>$type
            ]);
        }elseif($type==3){
            echo $this->render('create_3', [
                'model' => $model,'province'=>$province,'wechat_id'=>$wechat_id,'type'=>$type
            ]);
        }?>
    </div>
</div>
