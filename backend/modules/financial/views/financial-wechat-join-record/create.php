<?php
use yii\helpers\Html;
$this->title = '创建入会付款记录';
?>
<div class="financial-wechat-join-record-create">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            &times;
        </button>
        <h2 class="modal-title" id="myModalLabel">
            <?= Html::encode($this->title) ?>
        </h2>
    </div>
    <div class="modal-body">
    <?= $this->render('_form', [
        'model' => $model,'province'=>$province
    ]) ?>
    </div>
</div>
