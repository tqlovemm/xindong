<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model api\modules\v11\models\FormThread */

$this->title = 'Update Form Thread: ' . ' ' . $model->wid;
$this->params['breadcrumbs'][] = ['label' => 'Form Threads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->wid, 'url' => ['view', 'id' => $model->wid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="form-thread-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'tagList'=>$tagList
    ]) ?>

</div>
