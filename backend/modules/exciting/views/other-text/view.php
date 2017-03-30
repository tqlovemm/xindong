<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerCssFile('@web/js/lightbox/css/lightbox.css');
$this->registerJsFile('@web/js/lightbox/js/lightbox.min.js');
$pre_url = Yii::$app->params['threadimg'];
?>
<form action="">
    <input type="hidden" name="id" value="<?=Yii::$app->request->get('id')?>">
    <input type="text" name="number">
    <input type="submit">
</form>
<div class="album-view">
    <h1><?= Html::encode($this->title) ?></h1>
   <?php if ($count == 0): ?>
        <div class="no-photo">
            <img src="<?= Yii::getAlias('@web/images/no_photo.png') ?>" class="no-picture" alt="No photos">
            <div class="no-photo-msg">
                <div><?= Yii::t('app', 'No photo in this seek, click "Upload new photo" to make up your seek.') ?></div>
                <div class="button">
                    <div class="bigbutton">
                        <a href="<?= Url::toRoute(['/exciting/other-text/upload', 'id' => Yii::$app->request->get('id')]) ?>" class="btn btn-default">
                            <span class="glyphicon glyphicon-plus"></span> <?= Yii::t('app', 'Upload a new photo') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <a href="<?= Url::toRoute(['/exciting/other-text/upload', 'id' => Yii::$app->request->get('id')]) ?>" class="btn btn-default">
            <span class="glyphicon glyphicon-plus"></span> <?= Yii::t('app', 'Upload a new photo') ?>
        </a>
        <div class="img-all row clearfix">
            <?php foreach ($model as $photo): ?>
                <div class="col-md-1" id="<?= $photo['pid'] ?>" style="margin-bottom: 10px;background-color: #fff;margin-left: 5px;position: relative;">
                    <div class="img-wrap">
                        <div class="img-edit">
                            <a href="<?= Url::toRoute(['/exciting/other-text-pic/delete', 'id' => $photo['pid']]) ?>" data-clicklog="delete" data-confirm="Are you sure to delete it?" data-method="post" onclick="return false;" title="<?= Yii::t('app', 'Are you sure to delete it?') ?>">
                                <span class="img-tip"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                        </div>
                        <div class="img-main">
                            <a title="<?= Html::encode($photo['name']) ?>" href="<?=Url::to(['/exciting/other-text-pic/view','id'=>$photo['pid']])?>">
                                <img style="height: 100px;" src="<?= $pre_url.$photo['pic_path'] ?>">
                            </a>
                            <div class="img-name"><?= Html::encode($photo['name']) ?></div>
                            <div class="img-name"><?= Html::encode($photo['number']) ?></div>
                        </div>
                    </div>
                    <?php if($photo['status']==1):?><span style="position: absolute;color:#fff;top:0;right:0;background-color: rgba(255, 0, 0, 0.49);border-radius: 5px;padding:0 5px;font-size: 12px;">未发布</span><?php endif;?>
                </div>
            <?php endforeach ?>
        </div>
       <div class="row text-center">
           <?= \yii\widgets\LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>10]); ?>
       </div>
    <?php endif ?>
</div>
