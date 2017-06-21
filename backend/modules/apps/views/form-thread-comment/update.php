<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model api\modules\v11\models\FormThreadComments */

$this->title = 'Update Form Thread Comments: ' . ' ' . $model->comment_id;
$this->params['breadcrumbs'][] = ['label' => 'Form Thread Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->comment_id, 'url' => ['view', 'comment_id' => $model->comment_id, 'thread_id' => $model->thread_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="form-thread-comments-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
