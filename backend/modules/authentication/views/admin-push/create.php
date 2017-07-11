<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\authentication\models\AdminPush */

$this->title = 'Create Admin Push';
$this->params['breadcrumbs'][] = ['label' => 'Admin Pushes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-push-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
