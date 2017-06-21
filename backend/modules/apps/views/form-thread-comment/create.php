<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model api\modules\v11\models\FormThreadComments */

$this->title = 'Create Form Thread Comments';
$this->params['breadcrumbs'][] = ['label' => 'Form Thread Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-thread-comments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
