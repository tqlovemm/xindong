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
    <?= Html::a('<i class="glyphicon glyphicon-edit"></i> ' . Yii::t('app', 'Edit Seeks'), ['/exciting/exciting/update', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    <?php if ($model->photoCount == 0 && $model->created_by === Yii::$app->user->id): ?>
        <div class="no-photo">
            <img src="<?= Yii::getAlias('@web/images/no_photo.png') ?>" class="no-picture" alt="No photos">
            <div class="no-photo-msg">                       
                <div><?= Yii::t('app', 'No photo in this seek, click "Upload new photo" to make up your seek.') ?></div>
                <div class="button">
                    <div class="bigbutton">
                        <a href="<?= Url::toRoute(['/exciting/exciting/upload', 'id' => $model->id]) ?>" class="btn btn-default">
                            <span class="glyphicon glyphicon-plus"></span> <?= Yii::t('app', 'Upload a new photo') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <a href="<?= Url::toRoute(['/exciting/exciting/upload', 'id' => $model->id]) ?>" class="btn btn-default">
            <span class="glyphicon glyphicon-plus"></span> <?= Yii::t('app', 'Upload a new photo') ?>
        </a>
        <div class="img-all row clearfix">
            <?php Masonry::begin([
                'options' => [
                  'id' => 'photos'
                ],
                'pagination' => $model->photos['pages']
            ]); ?>
            <?php foreach ($model->photos['photos'] as $photo): ?>
                <div class="img-item col-md-1" id="<?= $photo['id'] ?>">
                    <div class="img-wrap">
                        <div class="img-edit">
                            <a href="<?= Url::toRoute(['/exciting/exciting-content/delete', 'id' => $photo['id']]) ?>" data-clicklog="delete" data-confirm="Are you sure to delete it?" data-method="post" onclick="return false;" title="<?= Yii::t('app', 'Are you sure to delete it?') ?>">
                                <span class="img-tip"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                        </div>
                        <div class="img-main">
                            <a title="<?= Html::encode($photo['name']) ?>" href="<?=Url::to(['/exciting/exciting-content-search/view','id'=>$photo['id']])?>">
                                <img class="img-thumbnail" src="<?= $pre_url.$photo['path'] ?>" width="100%" height="100%">
                            </a>
                            <div class="img-name"><?= Html::encode($photo['name']) ?></div> 
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
            <?php Masonry::end(); ?>
        </div>
    <?php endif ?>
</div>
