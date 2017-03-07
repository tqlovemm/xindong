<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\MemberSorts */

$this->title = '创建会员种类';
$this->params['breadcrumbs'][] = ['label' => '会员种类', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-sorts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
