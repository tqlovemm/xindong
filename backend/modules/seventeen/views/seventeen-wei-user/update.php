<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\seventeen\models\SeventeenWeiUser */

$this->title = '修改十一会员资料: ' . '编号' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Seventeen Wei Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'openid' => $model->openid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="seventeen-wei-user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'areas'=>$areas
    ]) ?>

</div>
