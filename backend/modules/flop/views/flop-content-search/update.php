<?php

use yii\helpers\Html;

$this->title = 'Update Flop Content: ' . ' ' . $model->area;

?>
<div class="weekly-content-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
