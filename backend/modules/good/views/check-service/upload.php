<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/5
 * Time: 15:08
 */
use shiyang\webuploader\MultiImage;
$this->title = "上传微信头像";
$this->params['breadcrumbs'][]=['label'=>$this->title,'url'=>['view','id'=>$model->id]];
$this->params['breadcrumbs'][]=Yii::t('app','Upload');
?>
<?=MultiImage::widget();?>
