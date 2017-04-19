<?php
use yii\helpers\Html;
$this->title = '创建微信';
?>
<div class="financial-wechat-create">
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
            'model' => $model,
        ]) ?>
    </div>
</div>
