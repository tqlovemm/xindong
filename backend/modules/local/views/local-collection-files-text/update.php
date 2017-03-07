<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\local\models\LocalCollectionFilesText */

$this->title = '修改地方啪会员信息，会员编号: ' . ' ' . $model->member_id;
$this->params['breadcrumbs'][] = ['label' => 'Local Collection Files Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->member_id, 'url' => ['view', 'id' => $model->member_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="local-collection-files-text-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
