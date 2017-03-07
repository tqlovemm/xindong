<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\bgadmin\models\BgadminMemberFlop */

$this->title = '创建翻牌记录';
$this->params['breadcrumbs'][] = ['label' => 'Bgadmin Member Flops', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bgadmin-member-flop-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
