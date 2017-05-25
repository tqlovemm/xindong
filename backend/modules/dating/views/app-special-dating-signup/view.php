<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "添加图片";
$pre_url = Yii::$app->params['test'];
?>

    <div class="album-view">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php if ($model->photoCount == 0): ?>
            <div class="no-photo">
                <img src="<?= Yii::getAlias('@web/images/no_photo.png') ?>" class="no-picture" alt="No images">
                <div class="no-photo-msg">
                    <div><?= Yii::t('app', 'No photo in this seek, click "Upload new photo" to make up your seek.') ?></div>
                    <div class="button">
                        <div class="bigbutton">
                            <a href="<?= Url::toRoute(['/dating/app-special-dating/upload', 'id' => $model->zid]) ?>" class="btn btn-default">
                                <span class="glyphicon glyphicon-plus"></span> 上传新图片
                            </a>
                            <a href="<?= Url::toRoute(['/dating/app-special-dating/uploadw', 'id' => $model->zid]) ?>" class="btn btn-default">
                                <span class="glyphicon glyphicon-plus"></span> 上传二维码
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <a href="<?= Url::toRoute(['/dating/app-special-dating/upload', 'id' => $model->zid]) ?>" class="btn btn-warning">
                <span class="glyphicon glyphicon-plus"></span> 上传新图片
            </a>
            <a href="<?= Url::toRoute(['/dating/app-special-dating/uploadw', 'id' => $model->zid]) ?>" class="btn btn-success">
                <span class="glyphicon glyphicon-plus"></span> 上传二维码
            </a>
            <hr>
            <div class="row">
            <div class="col-md-9">
                <div class="img-all clearfix box box-warning" style="padding: 10px;">
                    <p>档案图片</p>
                    <?php foreach ($model->images as $photo): ?>
                        <div class="img-item col-md-3" id="<?= $photo['pid'] ?>">
                            <div class="img-wrap">
                                <div class="img-main" style="position: relative;">
                                    <img class="img-responsive img-thumbnail" src="<?= $pre_url.$photo['img_path'] ?>">
                                    <div class="img-name">
                                        <?=Html::a('设为头像',['set-cover-photo','id'=>$photo['pid'],['class'=>'pull-left']])?>
                                        <a href="<?= Url::toRoute(['/dating/app-special-dating/delete-image', 'id' => $photo['pid']]) ?>" data-clicklog="delete" data-confirm="Are you sure to delete it?" data-method="post" onclick="return false;" title="<?= Yii::t('app', 'Are you sure to delete it?') ?>">
                                            <span class="img-tip pull-right">删除</span>
                                        </a>
                                    </div>
                                    <?php if($photo['type']):?><span style="position: absolute;width: 80px;height: 80px;border-radius: 50%;top:50%;left:50%;margin-top: -40px;margin-left:-40px;background-color: rgba(255, 0, 0, 0.5);text-align: center;line-height: 80px;color: #fff;">头像</span><?php endif;?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
            <?php if(!empty($model['weima'])):?>
            <div class="col-md-3">
                <div class="img-all clearfix box box-success" style="padding: 10px;">
                    <p>二维码图片</p>
                    <div class="img-item">
                        <div class="img-wrap">
                            <div class="img-main">
                                <img class="img-responsive" style="max-width: 100%;" src="<?= $pre_url.$model['weima']?>">
                                <div class="img-name">
                                    <a href="<?= Url::toRoute(['/dating/app-special-dating/delete-weima', 'id' => $model['zid']]) ?>" data-clicklog="delete" data-confirm="Are you sure to delete it?" data-method="post" onclick="return false;" title="<?= Yii::t('app', 'Are you sure to delete it?') ?>">
                                        <span class="img-tip pull-right">删除</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif;?>
            </div>
        <?php endif ?>
    </div>


