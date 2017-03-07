<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/15
 * Time: 9:42
 */
use yii\widgets\LinkPager;
$sum1=0;
$this->registerCss("


    .row .col-md-2,.row .col-md-1{padding:5px;border:1px solid #aaa;border-bottom:none;}

");
?>


<?php foreach($model as $key=>$val):

    $profile = new \frontend\models\UserProfile();
    $number = $profile->find()->select('number')->where(['user_id'=>$val['user_id']])->one();
    $sum1 =$sum1+ $val['number']
    ?>

    <div class="row" style="border-bottom:2px solid #ff8c08;margin-bottom: 10px;">
        <div class="col-md-2" ><?=$key?></div>
        <div class="col-md-2" >用户ID：<?=$val['user_id']?></div>
        <div class="col-md-2" >用户编号：<?=$number['number']?></div>
        <div class="col-md-2" >充值金额：<?=$val['number']?>元</div>
        <div class="col-md-2" >赠送金额：<?=$val['giveaway']?>元</div>
        <div class="col-md-2" >充值时间：<?=date('Y-m-d H:i:s',$val['updated_at'])?></div>
    </div>
<?php endforeach;?>
<h3 class="text-right">本页总计：<?=$sum1?>元</h3>
<h3 class="text-right">总计：<?=$sum?>元</h3>
<div class="clearfix"></div>
<?= LinkPager::widget(['pagination' => $pages]); ?>