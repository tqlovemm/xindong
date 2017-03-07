<?php

use yii\helpers\Html;

$this->title = '创建翻牌';

?>
<div class="flop-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
