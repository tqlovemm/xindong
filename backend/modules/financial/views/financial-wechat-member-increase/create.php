<?php
$this->title = '创建每日微信人数记录';
?>
<div class="financial-wechat-member-increase-create">
    <?= $this->render('_form', [
        'model' => $model,'total_count'=>$total_count
    ]) ?>
</div>
