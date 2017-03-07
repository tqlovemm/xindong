<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\bgadmin\models\SmadminMember */

$this->title = 'Create Smadmin Member';
$this->params['breadcrumbs'][] = ['label' => 'Smadmin Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bgadmin-member-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
