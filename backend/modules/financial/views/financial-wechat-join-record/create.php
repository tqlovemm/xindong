<?php
$this->title = '创建入会付款记录';
?>
<div class="row">
  <div class="col-md-6">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"><?=$this->title?></h3>
      </div>
      <div class="box-body">
        <?= $this->render('_form', [
            'model' => $model,'province'=>$province
        ]) ?>
      </div>
      <div class="box-footer">
      </div>
    </div>
  </div>
</div>