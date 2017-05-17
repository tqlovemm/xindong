<?php

use yii\widgets\LinkPager;
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = "创建会员专属";
?>
<p>
    <?= Html::a($this->title, ['create'], ['class' => 'btn btn-success']) ?>
</p>
<div class="row">
<?php foreach($model as $key=>$val):
    $albumUrl = Url::toRoute(['app-special-dating/view', 'id' => $val['zid']]);
    $src =$val->CoverPhoto;
    //$content = Html::encode($val['introduce']);
    ?>
    <div class="col-md-2">
        <a class="img-thumbnail" href="<?= $albumUrl ?>">
            <img src="<?= $src ?>" class="album-cover img-responsive" alt="album-cover" style="width:100%;height: 200px;">
        </a>
        <div class="album-info">
            <div class="album-desc">
                <div class="album-tit">
                    <a class="pull-left" href="<?=Url::to(['app-special-dating/update', 'id' => $val['zid']])?>">编辑</a>
                    <a class="pull-right" data-method="post" data-confirm="确定删除吗" href="<?=Url::to(['app-special-dating/delete', 'id' => $val['zid']])?>">删除</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach;?>
</div>
<?= LinkPager::widget(['pagination' => $pages]); ?>