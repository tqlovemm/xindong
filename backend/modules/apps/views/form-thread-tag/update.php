<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model api\modules\v11\models\FormThreadTag */

$this->title = 'Update Form Thread Tag: ' . ' ' . $model->tag_id;
$this->params['breadcrumbs'][] = ['label' => 'Form Thread Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tag_id, 'url' => ['view', 'id' => $model->tag_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="form-thread-tag-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
