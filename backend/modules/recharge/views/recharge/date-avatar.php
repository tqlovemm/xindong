<?php
use yii\helpers\Url;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/23
 * Time: 14:03
 */
$id = Yii::$app->request->get('id');
?>

<div class="container">
    <div class="row">

        <div class="col-md-4 col-md-offset-2">
            <?= \shiyang\webuploader\Cropper::widget() ?>
        </div>
        <div class="col-md-4">
            <a id="set-avatar" class="btn btn-success btn-lg" href='<?=Url::toRoute(['/recharge/recharge/avatar','id'=>$id])?>' onclick="return false;">
                系统头像
            </a>
            <div id="avatar-container"></div>
        </div>
    </div>
</div>
