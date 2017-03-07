<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\note\models\VoteSignInfo */

$this->title = 'Create Vote Sign Info';
$this->params['breadcrumbs'][] = ['label' => 'Vote Sign Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vote-sign-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
