<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/6
 * Time: 13:46
 */
use yii\helpers\Html;

use backend\modules\flop\models\FlopContentData;
$data = new FlopContentData();


?>
<div class="container">
    <div class="row"><a class="btn btn-default" href="/flop/flop/flop-data">返回</a></div>
    <div class="row">
        <table class="table table-bordered">
            <tr><td>User ID</td><td><?=$model->user_id?></td></tr>
            <tr><td>时间</td><td><?=date('Y-m-d H:i:s',$model->created_at)?></td></tr>
            <tr><td>唯一标识</td><td><?=$model->flag?></td></tr>
            <tr><td>简单描述</td><td>喜欢<?=count($model->content)?>人，翻牌<?=count($model->priority)?></td></tr>
            <tr>
                <td>喜欢</td>
                <td>
                    <?php foreach($model->content as $item):?>

                        <div class="pull-left text-center" style="border: 2px solid #ffa265;margin:5px;">
                            <a href="<?=$data->getPhoto($item)?>" data-lightbox="image-1">
                            <img style="width: 90px;height: 100px;" class="img-thumbnail" src="<?=$data->getPhoto($item)?>">
                                </a>
                            <div> <?=$data->getArea($item)?><?=$data->getNumber($item)?></div>
                        </div>
                    <?php endforeach;?>

                </td>
            </tr>
            <tr>
                <td>翻牌</td>
                <td>
                    <?php foreach($model->priority as $item):?>
                        <div class="pull-left text-center" style="border: 2px solid #14ffa5;margin:5px;">
                            <a href="<?=$data->getPhoto($item)?>" data-lightbox="image-1">
                                <img style="width: 90px;height: 100px;" class="img-thumbnail" src="<?=$data->getPhoto($item)?>">
                            </a>
                            <div> <?=$data->getArea($item)?><?=$data->getNumber($item)?></div>
                        </div>
                    <?php endforeach;?>
                </td>
            </tr>


        </table>


    </div>

</div>

