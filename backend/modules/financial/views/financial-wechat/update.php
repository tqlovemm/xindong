<?php
use yii\helpers\Html;
$this->title = 'Update Financial Wechat: ' . ' ' . $model->id;
?>
<div class="financial-wechat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
