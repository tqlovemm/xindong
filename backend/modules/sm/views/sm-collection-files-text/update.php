<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\sm\models\SmCollectionFilesText */

$this->title = '修改西蒙之家会员信息，会员编号: ' . ' ' . $model->member_id;
$this->params['breadcrumbs'][] = ['label' => 'Sm Collection Files Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->member_id, 'url' => ['view', 'id' => $model->member_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sm-collection-files-text-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
