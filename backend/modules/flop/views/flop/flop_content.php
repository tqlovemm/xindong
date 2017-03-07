<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/6
 * Time: 14:41
 */
use yii\widgets\LinkPager;


use yii\helpers\Html;
?>

<div class="container">


    <div class="row">
        <table class="table table-bordered">
            <tr><td>编号</td><td>地区</td><td>喜欢数</td><td>不喜欢数</td><td>身高</td><td>体重</td><td>头像</td><td>是否好评</td><td>是否发布</td></tr>
            <?php foreach($model as $key=>$val):?>
            <tr><td><?=$val['number']?></td><td><?=$val['area']?></td><td><?=$val['like_count']?></td>
                <td><?=$val['nope_count']?></td><td><?=$val['height']?></td><td><?=$val['weight']?></td>
                <td>
                    <a title="<?= Html::encode($val['area']) ?>" href="<?=$val['path']?>" data-lightbox="image-1">
                   点击查看
                    </a>
                </td><td><?=$val['other']?></td><td><?=$val['is_cover']?></td></tr>
            <?php endforeach;?>
        </table>

    </div>


</div>
<?= LinkPager::widget(['pagination' => $pages]); ?>