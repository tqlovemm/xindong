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
        <div class="row">
            <?php
            if($model->sex==0):
            $date = new \backend\modules\dating\models\Dating();
            foreach ($flops as $key=>$flop):?>
                <div class="rizhi" style="box-shadow: 0 5px 4px #E5E4E4;">
                    <div class="row" style="border-bottom: 1px dashed #eee;">
                        <div class="col-md-3">
                            <span style="display: inline-block;background-color: #ddd;color:#fff;width: 20px;height: 20px;border-radius: 50%;text-align: center;margin-right: 5px;">
                                <?=$key+1?>
                            </span>
                            <?=$flop['created_by']?>
                        </div>
                    </div>
                    <div class="row" style="border-bottom: 1px solid #eee;">
                        <div class="col-md-5">
                            <?=date('Y年m月d日',$flop['created_at'])?>，女生会员编号:<?=$flop['floping_number']?>对该男会员进行翻牌，该条记录由<?=$flop['created_by']?>创建生成
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        $dating = $date::find()->where(['number'=>$flop['floping_number']])->asArray()->all();
                        foreach ($dating as $list):?>
                            <div class="col-sm-1">
                                <a onclick="window.open('detail?id=<?=$list['number']?>&type=1','','toolbar=no,status=0,location=no,resizable=yes,menubar=no,scrollbars=yes,top='+(window.screen.availHeight-600)/2+',left='+(window.screen.availWidth-1000)/2+',height=600,width=600')" data-number="<?=$list['number']?>">
                                    <div style="width: 100px;height:100px;background-image: url('<?=$list['avatar']?>');background-size: cover;background-position: center;"></div>
                                </a>
                                <small><?=$flop['floping_number']?></small>
                            </div>
                        <?php endforeach;?>
                    </div>
                    <div class="row" style="border-top: 1px dashed #eee;">
                        <div class="col-md-12">
                            <?=date('Y年m月d日 H:i:s',$flop['created_at'])?>
                        </div>
                    </div>
                </div>
            <?php endforeach;else:
                $date = new \backend\modules\flop\models\FlopContent();
                foreach ($flops as $key=>$flop):?>
                    <div class="rizhi" style="box-shadow: 0 5px 4px #E5E4E4;">
                        <div class="row" style="border-bottom: 1px dashed #eee;">
                            <div class="col-md-3">
                            <span style="display: inline-block;background-color: #ddd;color:#fff;width: 20px;height: 20px;border-radius: 50%;text-align: center;margin-right: 5px;">
                                <?=$key+1?>
                            </span>
                                <?=$flop['created_by']?>
                            </div>
                        </div>
                        <div class="row" style="border-bottom: 1px solid #eee;">
                            <div class="col-md-5">
                                <?=date('Y年m月d日',$flop['created_at'])?>，该女生会员对编号为:<?=$flop['floped_number']?>的男会员进行翻牌，该条记录由<?=$flop['created_by']?>创建生成
                            </div>
                        </div>
                        <div class="row">
                            <?php
                            $dating = $date::find()->where(['number'=>$flop['floped_number']])->asArray()->all();
                            foreach ($dating as $list):?>
                                <div class="col-sm-1">
                                    <a onclick="window.open('detail?id=<?=$list['number']?>&type=0','','toolbar=no,status=0,location=no,resizable=yes,menubar=no,scrollbars=yes,top='+(window.screen.availHeight-600)/2+',left='+(window.screen.availWidth-1000)/2+',height=600,width=750')" data-number="<?=$list['number']?>">
                                        <div style="width: 100px;height:100px;background-image: url('<?=$list['content']?>');background-size: cover;background-position: center;"></div>
                                    </a>
                                </div>
                                <div class="col-sm-3">
                                    <h5>地区：<?=$list['area'];?></h5>
                                    <h5>会员编号：<?=$list['number'];?></h5>
                                    <h5>喜欢次数：<?=$list['like_count'];?></h5>
                                    <h5>不喜欢次数：<?=$list['nope_count'];?></h5>
                                </div>
                            <?php endforeach;?>

                        </div>
                        <div class="row" style="border-top: 1px dashed #eee;">
                            <div class="col-md-12">
                                <?=date('Y年m月d日 H:i:s',$flop['created_at'])?>
                            </div>
                        </div>
                    </div>

            <?php endforeach; endif;?>
        </div>
        <?= LinkPager::widget(['pagination' => $pages]); ?>
    </div>

</div>
