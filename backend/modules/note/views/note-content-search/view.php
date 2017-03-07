<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="row">
    <a href="<?= Url::toRoute(['/note/note-content/upload', 'id' => Yii::$app->request->get('id')]) ?>" class="btn btn-default">
        <span class="glyphicon glyphicon-plus"></span> 上传新图片
    </a>

</div>

<div class="weekly-content-view">
    <div class="row">
        <?php foreach ($model as $item):?>
            <div class="col-xs-2" style="margin: 10px;">
                <img class="img-responsive" src="<?=$item['path']?>">
                <a href="<?= Url::toRoute(['/note/note-content-search/delete-detail','id'=>$item['id']]) ?>" data-clicklog="delete" data-confirm="Are you sure to delete it?" data-method="post" onclick="return false;" title="<?= Yii::t('app', 'Are you sure to delete it?') ?>">
                    <span class="img-tip"><i class="glyphicon glyphicon-remove"></i>删除</span>
                </a>
            </div>

        <?php endforeach;?>
    </div>
</div>
