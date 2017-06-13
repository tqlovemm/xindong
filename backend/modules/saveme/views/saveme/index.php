<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\saveme\models\SavemeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '救我管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .list img{display: inline-block;width: 50%;vertical-align: top;}
    .list li{position: relative;font-size: 0;padding: 0 10px;line-height: 1;margin-bottom: 15px;float: left;width: 33%;height: 254px;}
    .list li div{display: inline-block;width: 50%;padding-left: 10px;box-sizing: border-box;}
    .list li div h2{font-size: 13px;line-height: 1;margin-top: 0px;}
    .list li div p{bottom: 0;color: #666;font-size: 13px;line-height: 15px;}
    .list li div p i{margin: 0 5px;}
    .list li div p img{width: 17px;display: inline-block;vertical-align: middle;margin-right: 5px;margin-top: -3px;}
    .dibu{position: absolute;margin-bottom: 0px;}
</style>
<div class="saveme-index">

    <h1>救我发布列表</h1>
    <p>
        <!--<?= Html::a('添加救我', ['create'], ['class' => 'btn btn-success']) ?>-->
    </p>
    <?= $this->render('_search', ['model' => $searchModel]); ?>
    <ul class="list">
        <?php foreach ($dataProvider as $vo): ?>
            <li>
                <span>
                <img src='<?= Html::encode("{$vo->Photo['path']}") ?>' height="254px">
                </span>
                <div>
                    <h2>发布人ID：<?= $vo->User['id']; ?></h2>
                    <p>发布人：<?= $vo->User['nickname']?$vo->User['nickname']:$vo->User['username']; ?><p/>
                    <p>地址：<?= $vo->address ?><p/>
                    <p>结束时间：<?= date('Y-m-d',$vo->end_time) ?><p/>
                    <p>详情：<?= $vo->content; ?><p/>
                    <p>报名人数：<?= $bmcount[$vo->id]; ?><p/>
                    <p>救我状态：
                    <?php $res = $vo->status;$endtime = $vo->end_time;if($endtime < time()){?>
                        <font color='orange'>已过期</font>
                    <?php }elseif($res == 2){ ?>
                        <font color='green'>已结束</font>
                    <?php }elseif($res == 0){ ?>
                        <font color='red'>已删除</font>
                    <?php }elseif($res == 3){ ?>
                        <font color='red'>未审核</font>
                    <?php }elseif($res == 4){ ?>
                        <font color='red'>审核不通过</font>
                    <?php }else{ ?>
                        <font color='blue'>正常</font>
                    <?php }; ?>
                    <p/>
                    <p class="dibu">
                    <td>
                        <a href="/saveme/saveme/view?id=<?= $vo->id; ?>" title="View" aria-label="View" data-pjax="0">
                            <span class="glyphicon glyphicon-eye-open"></span>
                        </a>
                        <a href="/saveme/saveme/update?id=<?= $vo->id; ?>" title="Update" aria-label="Update" data-pjax="0">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a> <a href="/saveme/saveme/delete?id=<?= $vo->id; ?>" title="Delete" aria-label="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post" data-pjax="0">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    </td>
                    </p>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <div style="clear: both;">
    <?=LinkPager::widget(['pagination' => $pages,]); ?>
    </div>
</div>