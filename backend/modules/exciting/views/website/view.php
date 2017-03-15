<?php

use yii\helpers\Html;
use yii\helpers\Url;
use shiyang\masonry\Masonry;

/* @var $this yii\web\View */
/* @var $model app\modules\home\models\Album */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Seeks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$pre_url = Yii::$app->params['threadimg'];
?>

<div class="album-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('<i class="glyphicon glyphicon-edit"></i> ' . Yii::t('app', 'Edit Seeks'), ['/exciting/website/update', 'id' => $model->website_id], ['class' => 'btn btn-default']) ?>
    <?php if ($model->photoCount == 0): ?>
        <div class="no-photo">
            <img src="<?= Yii::getAlias('@web/images/no_photo.png') ?>" class="no-picture" alt="No photos">
            <div class="no-photo-msg">                       
                <div><?= Yii::t('app', 'No photo in this seek, click "Upload new photo" to make up your seek.') ?></div>
                <div class="button">
                    <div class="bigbutton">
                        <a href="<?= Url::toRoute(['/exciting/website/upload', 'id' => $model->website_id]) ?>" class="btn btn-default">
                            <span class="glyphicon glyphicon-plus"></span> <?= Yii::t('app', 'Upload a new photo') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
       <a href="<?= Url::toRoute(['/exciting/website/upload', 'id' => $model->website_id]) ?>" class="btn btn-default">
            <span class="glyphicon glyphicon-plus"></span> <?= Yii::t('app', 'Upload a new photo') ?>
        </a>
        <div class="img-all row clearfix">
            <?php foreach ($model->photo as $photo): ?>
                <div class="img-item col-md-3" id="<?= $photo['cid'] ?>">
                    <div class="img-wrap">
                        <div class="img-main">
                            <a title="<?= Html::encode($photo['name']) ?>" href="<?=Url::to(['/exciting/website-content-search/view','id'=>$photo['cid']])?>">
                                <img class="img-responsive" src="<?= $pre_url.$photo['path'] ?>">
                            </a>
                            <div class="img-name" style="padding: 10px;background-color: #fff;font-size: 18px;text-align: center;margin-top: 5px;"><?= Html::encode($photo['name']) ?></div>
                        </div>
                        <div class="img-edit" style="margin-top: 5px;">
                            <a class="pull-left" href="<?= Url::toRoute(['/exciting/website/upload', 'type' => $photo['cid'], 'id' => $model->website_id]) ?>">
                                <span class="btn btn-success">修改图片</span>
                            </a>
                            <a class="pull-left"  data-clicklog="delete" data-confirm="Are you sure to delete it?" data-method="post" onclick="return false;" href="<?= Url::toRoute(['/exciting/website-content-search/delete', 'id' => $photo['cid']]) ?>">
                                <span class="btn btn-danger">删除</span>
                            </a>
                            <a class="pull-right" href="<?= Url::toRoute(['/exciting/website-content-search/update', 'id' => $photo['cid']]) ?>">
                                <span class="btn btn-warning">修改文字</span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>
