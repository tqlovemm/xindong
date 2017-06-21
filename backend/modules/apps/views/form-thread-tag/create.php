<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model api\modules\v11\models\FormThreadTag */

$this->title = 'Create Form Thread Tag';
$this->params['breadcrumbs'][] = ['label' => 'Form Thread Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-thread-tag-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
