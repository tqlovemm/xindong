<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\bgadmin\models\SeventeenadminMember */

$this->title = 'Create Seventeenadmin Member';
$this->params['breadcrumbs'][] = ['label' => 'Seventeenadmin Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bgadmin-member-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
