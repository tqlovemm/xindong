<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\member\models\DatingVip */

$this->title = 'Create Dating Vip';
$this->params['breadcrumbs'][] = ['label' => 'Dating Vips', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dating-vip-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
