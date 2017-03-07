<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\bgadmin\models\BgadminMember */

$this->title = 'Update Bgadmin Member: ' . ' ' . $model->member_id;
$this->params['breadcrumbs'][] = ['label' => 'Bgadmin Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->member_id, 'url' => ['view', 'id' => $model->member_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bgadmin-member-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'area'=>$area
    ]) ?>

</div>
