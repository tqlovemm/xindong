<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $model backend\modules\bgadmin\models\BgadminMember */

$this->params['breadcrumbs'][] = ['label' => 'Bgadmin Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$url = Yii::$app->request->getPathInfo();
$url_q = explode('/',$url);
$url_end = $url_q[count($url_q)-1];
$this->registerCss("
    .rizhi{background-color: #fff;border-radius: 5px;margin-bottom: 15px;padding:0 15px;}
    .container-fluid .row{margin:0;padding:10px 0;}
    .container-fluid .row .col-md-2{padding:0;}
    .container-fluid .row .col-md-3{padding:0;}
    .container-fluid .row .col-md-4{padding:0;}
    .container-fluid .row .col-md-5{padding:0;}
    .container-fluid .row .col-md-9{padding:0;padding-left:8px;padding-right:4px;}
    .container-fluid .row .col-md-12{padding:0;}
    .container-fluid .row .col-sm-2{padding:0 10px 0 0;}
    .container-fluid{margin-left:0;}
");
$pre_url = Yii::$app->params['imagetqlmm'];
?>

<div class="bgadmin-member-view clearfix">
    <p>
        <?= Html::a('编辑基础资料', ['update', 'id' => $model->member_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除会员', ['delete', 'id' => $model->member_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('添加新记录', ['active-record', 'id' => $model->member_id], ['class' => 'btn btn-warning']) ?>
    </p>
    <h3>基础资料</h3>
    <table class="table table-bordered table-hover" style="background-color: #fff;">
        <tbody>
        <tr>
            <td>编号</td><td>微信号</td>
            <td>手机号</td><td>微博号</td><td>主地址</td>
            <td>其他地址</td>
        </tr>
        <tr>
            <th><?=$model->number?></th>
            <th><?=$model->weicaht?></th><th><?=$model->cellphone?></th>
            <th><?=$model->weibo?></th><th><?=$model->address_a?></th>
            <th><?=$model->address_b?></th>
        </tr>
        <tr>
            <td>入会时间</td><td>基础资料入库时间</td><td>基础资料更新时间</td><td>基础资料创建人</td>
            <td>性别（[男:0]、[女:1]）</td>
            <td>会员等级（[非:0]、[女生:1]、[普通:2]、[高端:3]、[至尊:4]、[私人:5]）</td>
        </tr>
        <tr>
            <th><?=$model->time?></th>
            <th><?=date('Y-m-d H:i:s',$model->created_at)?></th>
            <th><?=date('Y-m-d H:i:s',$model->updated_at)?></th>
            <th><?=$model->created_by?></th>
            <th><?=$model->sex?></th>
            <th><?=$model->vip?></th>
        </tr>
        </tbody>
    </table>
    <h3>活动记录</h3>
    <div class="container-fluid" style="padding:0;position: relative;">
        <div class="row" style="margin-top: 10px;margin-right: 0;margin-left: 0;">
            <ul class="list-group">
                <a class="inline list-group-item <?php if(in_array($url_end,['view-file'])){echo 'active';}?>" href="<?=Url::toRoute(['view-file','id'=>$model->number,'mid'=>$model->member_id])?>">个人档案信息</a>
                <a class="inline list-group-item <?php if(in_array($url_end,['view'])){echo 'active';}?>" href="<?=Url::toRoute(['view','id'=>$model->member_id])?>">二维码图片</a>
                <a class="inline list-group-item <?php if(in_array($url_end,['view-photo'])){echo 'active';}?>" href="<?=Url::toRoute(['view-photo','id'=>$model->member_id])?>">生活档案照</a>
                <a class="inline list-group-item <?php if(in_array($url_end,['view-pay'])){echo 'active';}?>" href="<?=Url::toRoute(['view-pay','id'=>$model->member_id])?>">付款截图</a>
                <a class="inline list-group-item <?php if(in_array($url_end,['view-chat'])){echo 'active';}?>" href="<?=Url::toRoute(['view-chat','id'=>$model->member_id])?>">聊天截图</a>
                <a class="inline list-group-item <?php if(in_array($url_end,['view-flop'])){echo 'active';}?>" href="<?=Url::toRoute(['view-flop','id'=>$model->member_id])?>">翻牌记录</a>
                <a class="inline list-group-item <?php if(in_array($url_end,['view-dating'])){echo 'active';}?>" href="<?=Url::toRoute(['view-dating','id'=>$model->member_id])?>">觅约记录</a>
                <a class="inline list-group-item <?php if(in_array($url_end,['view-feedback'])){echo 'active';}?>" href="<?=Url::toRoute(['view-feedback','id'=>$model->member_id])?>">反馈记录</a>
                <a class="inline list-group-item <?php if(in_array($url_end,['view-other'])){echo 'active';}?>" href="<?=Url::toRoute(['view-other','id'=>$model->member_id])?>">其他记录</a>
            </ul>
        </div>
        <?php if(!empty($file)&&$model->sex==0):?>
        <div class="row">
            <table class="table table-bordered table-hover" style="background-color: #fff;">
                <tbody>
                <tr>
                    <td>编号</td><td>微信号</td>
                    <td>手机号</td><td>微博号</td><td>QQ</td>
                    <td>邮箱</td>
                    <td>微信二维码</td>
                </tr>
                <tr>
                    <th><?=$file->id?></th>
                    <th><?=$file->weichat?></th><th><?=$file->cellphone?></th>
                    <th><?=$file->weibo?></th><th><?=$file->qq?></th>
                    <th><?=$file->email?></th>
                    <th rowspan="7"><a href="<?=$pre_url.$file->weima?>" data-title="<?=$file->id?>" data-lightbox="s"><img style="width: 140px;" class="img-responsive" src="<?=$pre_url.$file->weima?>"></a></th>
                </tr>
                <tr>
                    <td>年龄</td><td>基础资料入库时间</td><td>基础资料更新时间</td>
                    <td>身高</td><td>体重</td> <td>工作职业</td>

                </tr>
                <tr>
                    <th><?=date('Y-m-d',$file->age)?></th>
                    <th><?=date('Y-m-d H:i:s',$file->created_at)?></th>
                    <th><?=date('Y-m-d H:i:s',$file->updated_at)?></th>
                    <th><?=$file->height?></th>
                    <th><?=$file->weight?></th>
                    <th><?=$file->job?></th>

                </tr>
                <tr>
                    <td>喜欢妹子类型</td><td>车型</td><td>年薪</td><td>地址</td> <td>常去地</td><td>婚否（0单身，1有女朋友，2已婚）</td>
                </tr>
                <tr>
                    <th><?=$file->like_type?></th>
                    <th><?=$file->car_type?></th>
                    <th><?=$file->annual_salary?></th>
                    <th><?=$file->address?></th>
                    <th><?=$file->often_go?></th>
                    <th><?=$file->marry?></th>

                </tr>
                <tr>
                    <td>性别（[男:0]、[女:1]）</td><td>兴趣爱好</td><td>填写审核情况</td><td colspan="3">其他备注</td>
                </tr>
                <tr>
                    <th><?=$file->sex?></th><th><?=$file->hobby?></th><th><?=$file->status?> <small>(0未填写，1已填等待审核中，2审核通过，3未通过修改中)</small></th>
                    <th colspan="3"><?=$file->extra?></th>
                </tr>

                </tbody>
            </table>
        </div>
        <div class="row">
            <?php foreach ($imgs as $img):?>
                <div class="col-md-2" style="padding:10px;"><img style="width: 100px;" class="img-responsive" src="<?=$pre_url.$img['img']?>"></div>
            <?php endforeach;?>
        </div>
        <?php elseif(!empty($file)&&$model->sex==1):?>
            <div class="row">
                <table class="table table-bordered table-hover" style="background-color: #fff;">
                    <tbody>
                    <tr>
                        <td>女生编号</td><td>地区一</td>
                        <td>地区二</td><td>地区三</td><td>妹子标签</td>
                        <td>交友要求</td>
                        <td>创建时间</td>
                        <td>价值</td>
                        <td>管理员</td>
                        <td>头像</td>
                    </tr>
                    <tr>
                        <th><?=$file->number?></th>
                        <th><?=$file->title?></th>
                        <th><?=$file->title2?></th>
                        <th><?=$file->title3?></th>
                        <th><?=$file->content?></th>
                        <th><?=$file->url?></th>
                        <th><?=date('Y-m-d H:i:s',$file->created_at)?></th>
                        <th><?=$file->worth?></th>
                        <th><?=\backend\models\User::getUsername($file->created_by)?></th>
                        <td rowspan="4"><img style="width: 100px;" src="<?=$file->avatar?>"></td>
                    </tr>
                    <tr>
                        <td colspan="9">简介</td>
                    </tr>
                    <tr>
                        <th colspan="9"><?=$file->introduction?></th>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <?php foreach ($imgs['photos'] as $img):?>
                    <div class="col-md-2" style="padding:10px;"><img class="img-responsive" src="<?=$pre_url.$img['path']?>"></div>
                <?php endforeach;?>
            </div>

        <?php else:?>
            <h4>数据为空</h4>
        <?php endif;?>
    </div>

</div>
