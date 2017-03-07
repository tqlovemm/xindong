<?php

use yii\helpers\Html;
use shiyang\webuploader\MultiImage;
/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\WeichatVote */

$this->title = 'Update Weichat Vote: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Weichat Votes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="weichat-vote-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
