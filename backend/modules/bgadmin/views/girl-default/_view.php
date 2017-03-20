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
$pre_url = Yii::$app->params['shisangirl'];
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
            <td>节操币</td>
        </tr>
        <tr>
            <th><?=$model->number?></th>
            <th><?=$model->weicaht?></th><th><?=$model->cellphone?></th>
            <th><?=$model->weibo?></th><th><?=$model->address_a?></th>
            <th><?=$model->address_b?></th>
            <th><?=$model->coin?></th>
        </tr>
        <tr>
            <td>入会时间</td><td>基础资料入库时间</td><td>基础资料更新时间</td><td>基础资料创建人</td>
            <td>性别（[男:0]、[女:1]）</td>
            <td colspan="2">会员等级（[非:0]、[女生:1]、[普通:2]、[高端:3]、[至尊:4]、[私人:5]）</td>
        </tr>
        <tr>
            <th><?=$model->time?></th>
            <th><?=date('Y-m-d H:i:s',$model->created_at)?></th>
            <th><?=date('Y-m-d H:i:s',$model->updated_at)?></th>
            <th><?=$model->created_by?></th>
            <th><?=$model->sex?></th>
            <th colspan="2"><?=$model->vip?></th>
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
        <div style="width: 70%;float: left;">
            <?php foreach ($weimas as $key=>$item):?>
                <div class="rizhi" style="box-shadow: 0 5px 4px #E5E4E4;">
                    <div class="row" style="border-bottom: 1px dashed #eee;">
                        <div class="col-md-3">
                            <span style="display: inline-block;background-color: #ddd;color:#fff;width: 20px;height: 20px;border-radius: 50%;text-align: center;margin-right: 5px;">
                                <?=$key+1?>
                            </span>
                            <?=$item['created_by']?>
                        </div>
                    </div>
                    <div class="row" style="border-bottom: 1px solid #eee;">
                        <div class="col-md-5">
                            活动描述：<?=$item['content']?>
                        </div>
                        <div class="col-md-3">
                            活动时间：<?=$item['time']?>
                        </div>
                        <div class="col-md-4">
                            <?= Html::a('上传图片', ['upload', 'id' => $item['text_id']], ['class' => 'btn-sm btn-default']) ?>
                            <?= Html::a('编辑资料', ['update-text', 'id' => $item['text_id']], ['class' => 'btn-sm btn-default']) ?>
                            <?= Html::a('删除记录', ['delete-text', 'id' => $item['text_id']], [
                                'class' => 'btn-sm btn-default',
                                'data' => [
                                    'confirm' => '确定删除吗?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <?php foreach ($item['memberFiles'] as $list):?>
                            <div class="col-sm-2">
                                <a href="<?=$pre_url.$list['path']?>" data-title="<?=$list['content']?>" data-lightbox="d">
                                    <div style="width: 100%;height:200px;background-image: url('<?=$pre_url.$list['path']?>');background-size: cover;background-position: center;"></div>
                                </a>
                                <?= Html::a('', ['update-img', 'id' => $list['id']], ['class' => 'glyphicon glyphicon-pencil pull-left']) ?>
                                <?= Html::a('', ['delete-img', 'id' => $list['id']], [
                                    'class' => 'glyphicon glyphicon-trash pull-right',
                                    'data' => [
                                        'confirm' => '确定删除吗?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            </div>
                        <?php endforeach;?>
                    </div>
                    <div class="row" style="border-top: 1px dashed #eee;">
                        <div class="col-md-12">
                            <?=date('Y年m月d日 H:i:s',$item['created_at'])?>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
            <?=LinkPager::widget(['pagination' => $pagination]);?>
        </div>
        <?php if($record!=0):?>
        <div style="width: 29%;float: right;">
            <div class="rizhi" style="box-shadow: 0 5px 4px #E5E4E4;padding:7px 10px;">
                <h5><?=$this->title?>总数：<?=$record?></h5>
                <h5>包含图片总数：<?=$count?></h5>
            </div>
            <div class="rizhi" style="box-shadow: 0 5px 4px #E5E4E4;padding:7px 10px;">
                <?php foreach ($imgs as $list):?>
                    <div class="row" style="padding: 8px 0;border-bottom: 1px dashed #ddd;">
                        <div class="col-md-3">
                            <a href="<?=$list['path']?>" data-title="<?=$list['content']?>" data-lightbox="d">
                                <div style="width: 90%;height:90px;background-image: url('<?=$pre_url.$list['path']?>');background-size: cover;background-position: center;"></div>
                            </a>
                        </div>
                        <div class="col-md-9">
                            <h5 style="margin-top: 0;" class="clearfix">
                                <span class="pull-left"><?=$list['created_by']?></span>
                                <a class="pull-right" style="margin-left: 15px;" href="update-img?id=<?=$list['id']?>">改</a>
                                <span class="pull-right"><?=date('Y-m-d',$list['created_at'])?></span>
                            </h5>
                            <p><?=$list['content']?></p>
                        </div>
                    </div>
                <?php endforeach;?>
                <?=LinkPager::widget(['pagination' => $pagination2]);?>
            </div>
        </div>
        <?php endif;?>
    </div>
</div>
