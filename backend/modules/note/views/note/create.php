<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\home\models\Album */

$this->title = '创建心动故事';

?>
<div class="album-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
