<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\bgadmin\models\BgadminMemberFlop */

$this->title = 'Update Bgadmin Member Flop: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bgadmin Member Flops', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bgadmin-member-flop-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form2', [
        'model' => $model,
    ]) ?>

</div>
