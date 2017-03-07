<?php

use yii\helpers\Html;
use yii\helpers\Url;
use shiyang\masonry\Masonry;
use yii\helpers\ArrayHelper;
use app\modules\home\models\Album;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $model app\modules\home\models\Album */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'My Albums'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/js/lightbox/css/lightbox.css');
$this->registerJsFile(Yii::getAlias('@web')."/js/jquery-1.11.3.js",['position' => View::POS_HEAD]);
$this->registerJsFile('@web/js/lightbox/js/lightbox.min.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);

?>

<?= Html::activeDropDownList($model, 'id', ArrayHelper::map(Album::find()->all(), 'id', 'name'),['class' => 'form-control','style'=>'width:200px;'])?>

<script>

    $(function(){

        $('#album-id').change(

            function(){

                var $id = jQuery("#album-id  option:selected").val();

                window.location.href = '/index.php/home/seek/view?id='+$id;

        });
    })
</script>
<div class="album-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php if ($model->photoCount == 0 && $model->created_by === Yii::$app->user->id): ?>
        <div class="no-photo">
            <img src="<?= Yii::getAlias('@web/images/no_photo.png') ?>" class="no-picture" alt="No photos">
            <div class="no-photo-msg">
                <div><?= Yii::t('app', 'No photo in this album, click "Upload new photo" to make up your album.') ?></div>
                <div class="button">
                    <div class="bigbutton">
                        <a href="<?= Url::toRoute(['/home/album/upload', 'id' => $model->id]) ?>" class="btn btn-default">
                            <span class="glyphicon glyphicon-plus"></span> <?= Yii::t('app', 'Upload a new photo') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="img-all row">
            <?php Masonry::begin([
                'options' => [
                    'id' => 'photos'
                ],
                'pagination' => $model->photos['pages']
            ]); ?>
            <?php foreach ($model->photos['photos'] as $photo): ?>
                <div class="img-item col-md-3" id="<?= $photo['id'] ?>">
                    <div class="img-wrap">
                        <div class="img-main">
                            <a title="<?= Html::encode($photo['name']) ?>" href="<?= $photo['path']?>" data-lightbox="image-1" data-title="<?= Html::encode($photo['name']) ?>">
                                <img src="<?= $photo['path'] ?>">
                            </a>
                            <div class=" text-left">地址：<?= Html::encode($photo['name']) ?></div>
                            <div class=" text-left"><?= date('Y-m-d H:i:s',$photo['created_at'])?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
            <?php Masonry::end(); ?>
        </div>
    <?php endif ?>
</div>
