<?php
$this->title = "到期会员列表";
use common\components\Vip;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use api\modules\v11\models\User;
$this->registerCss("

.vip-type{position: absolute;top:50%;left:50%;margin-top:-40px;margin-left:-40px;width:80px;height:80px;border-radius:50%;text-align:center;line-height:80px;font-size:36px;color:#868686;}

");
?>
<p>
    <?= Html::a("创建到期会员", ['create'], ['class' => 'btn btn-success']) ?>
</p>
<?php  echo $this->render('_search', ['model' => $searchModel]); ?>
<div style="margin-bottom: 15px;">
    <?=$dataProvider['sort']->link('expire') . '&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;' . $dataProvider['sort']->link('created_at'). '&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;' .$dataProvider['sort']->link('type');?>
</div>
<div class="row">
    <?php foreach($dataProvider['model'] as $key=>$val):

        if(!empty($val->user_id)){
            $user_id = $val->user_id;
        }else{
            $user_id = \backend\models\User::getId($val->number);
        }

        if(!empty($user_id)){
            $avatar = !empty(User::findOne($val->user_id)->avatar)?User::findOne($val->user_id)->avatar:'http://omsnqyd5g.bkt.clouddn.com/extra/timg.jpg';
        }else{
            $avatar = 'http://omsnqyd5g.bkt.clouddn.com/extra/timg.jpg';
        }
        $avatar = !empty($val->user_id)?User::findOne($val->user_id)->avatar:'http://omsnqyd5g.bkt.clouddn.com/extra/timg.jpg';
        $nickname = !empty($val->number)?'编号：'.$val->number:'ID：'.$val->user_id;
        $expire = strtotime($val->expire) - time();
        $expiration = 0;
        $expiration_text = "已经过期";
        if($expire>0){
            if($expire<86400*30){
                $expiration_text = '即将到期，剩余时间';
                $bg = "bg-blue";
            }else{
                $expiration_text = '到期时间还剩';
                $bg = "bg-green";
            }
            $expiration = \common\components\Vip::vip_expire($expire);

        }else{
            $bg = "bg-red";
        }
        ?>
    <div class="col-md-4">
        <div class="box box-widget widget-user-2">
            <div class="widget-user-header <?=$bg?>">
                <div class="widget-user-image">
                    <img class="img-circle" src="<?=$avatar?>" alt="User Avatar">
                </div>
                <h3 class="widget-user-username"><?=$nickname?></h3>
                <h5 class="widget-user-desc">创建：<?=date('Y-m-d H:i:s',$val->created_at)?></h5>
            </div>
            <div class="box-footer no-padding" style="position: relative;">
                <ul class="nav nav-stacked">
                    <li><a href="#">到期时间<span class="pull-right badge bg-yellow"><?=$val->expire?></span></a></li>
                    <li><a href="update?id=<?=$val->vid?>"><?=$expiration_text?><span class="pull-right badge <?=$bg?>"><?=$expiration?></span></a></li>
                    <li><a href="#">会员等级 <span class="pull-right badge bg-blue"><?=Vip::vip($val->vip)?></span></a></li>
                    <li><a href="#">备注 <span class="pull-right badge bg-green"><?=$val->extra?></span></a></li>
                    <li><a href="delete?id=<?=$val->vid?>" data-confirm="确认删除吗？删除将无法恢复！！！">创建人 <span class="pull-right badge bg-aqua"><?=$val->admin?></span></a></li>
                </ul>
                <?=Vip::vip_type($val->type,1)?>
            </div>
        </div>
    </div>
    <?php endforeach;?>
</div>


<?= LinkPager::widget(['pagination' => $dataProvider['pages']]); ?>