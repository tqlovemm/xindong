<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\bgadmin\models\SmadminMember */

$this->title = 'Update Smadmin Member: ' . ' ' . $model->member_id;
$this->params['breadcrumbs'][] = ['label' => 'Bgadmin Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->member_id, 'url' => ['view', 'id' => $model->member_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bgadmin-member-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
