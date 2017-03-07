<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\bgadmin\models\SeventeenadminMember */

$this->title = 'Update Seventeenadmin Member: ' . ' ' . $model->member_id;
$this->params['breadcrumbs'][] = ['label' => 'Seventeenadmin Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->member_id, 'url' => ['view', 'id' => $model->member_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bgadmin-member-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
