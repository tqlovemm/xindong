<?php

use yii\helpers\Html;


$this->title = '发表评论';

?>
<div class="weekly-comment-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
