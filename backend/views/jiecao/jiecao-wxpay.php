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


    .row .col-md-2,.row .col-md-1,.row .col-md-3{padding:5px;border-left:1px solid #aaa;border-top:1px solid #aaa;border-bottom:none;min-height:50px;}

");
?>
    <div class="row" style="border-bottom:2px solid #ff8c08;margin-bottom: 10px;">
        <div class="col-md-1" >用户ID</div>
        <div class="col-md-1" >用户编号</div>
        <div class="col-md-1" >充值金额</div>
        <div class="col-md-1" >得到节操币</div>
        <div class="col-md-1" >赠送节操币</div>
        <div class="col-md-2" >充值时间</div>
        <div class="col-md-1" >类型</div>
        <div class="col-md-1" >是否关注公众</div>
        <div class="col-md-3" >描述</div>
    </div>
<?php foreach($model as $key=>$val):

    $profile = new \frontend\models\UserProfile();
    $number = $profile->find()->select('number')->where(['user_id'=>$val['user_id']])->one();
    $sum1 =$sum1+ $val['total_fee'];

    if($val['type']==2){

        $type='节操币充值';
        $jiecao = $val['total_fee'];
        $giveaway = $val['giveaway'];
        $pay_info = json_decode($val['extra'],true);
        $groupid = '';
        $introduce = "会员节操币充值";

    }elseif($val['type']==3){

        $type='会员升级';
        $pay_info = json_decode($val['extra'],true);
        $jiecao = 0;
        $giveaway = json_decode($val['giveaway'],true);
        $groupid= json_decode($pay_info['attach'],true)['groupid'];
        switch ($groupid){


            case 1:$grade = "网站会员";break;
            case 2:$grade = "普通会员";break;
            case 3:$grade = "高端会员";break;
            case 4:$grade = "至尊会员";break;
            case 5:$grade = "私人定制";break;
            default: $grade = "其他";;

        }
        $introduce = "会员升级，升到到$grade";

    }else{

        $type='添加地区';
        $pay_info = json_decode($val['extra'],true);
        $jiecao = 0;
        $giveaway = 0;
        $val['user_id'] = "17高端会员";
        $a= explode(',',urldecode(json_decode($pay_info['attach'],true)['area']));
        $openid = json_decode($pay_info['attach'],true)['groupid'];
        $number = (new \yii\db\Query())->select('id as number')->from('pre_collecting_17_wei_user')->where(['openid'=>$openid])->one();
        $area = (new \yii\db\Query())->select('address_province')->from('pre_collecting_17_files_text')->where(['id'=>$a])->column();
        $areas = implode(',',$area);
        $introduce = "开通$areas";

    }

?>

    <div class="row" style="border-bottom:2px solid #ff8c08;margin-bottom: 10px;">
        <div class="col-md-1" ><?=$val['user_id']?></div>
        <div class="col-md-1" ><?=$number['number']?></div>
        <div class="col-md-1" ><?=$val['total_fee']?>元</div>
        <div class="col-md-1" ><?=$jiecao?></div>
        <div class="col-md-1" ><?=$giveaway?></div>
        <div class="col-md-2" ><?=date('Y-m-d H:i:s',$val['updated_at'])?></div>
        <div class="col-md-1" ><?=$type?></div>
        <div class="col-md-1" ><?=$pay_info['is_subscribe']?></div>
        <div class="col-md-3" ><?=$introduce?></div>
    </div>
<?php endforeach;?>
<h3 class="text-right">本页总计：<?=$sum1?>元</h3>
<h3 class="text-right">总计：<?=$sum?>元</h3>
<div class="clearfix"></div>
<?= LinkPager::widget(['pagination' => $pages]); ?>