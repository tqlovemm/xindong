<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model api\modules\v11\models\FormThread */

$this->title = 'Create Form Thread';
$this->params['breadcrumbs'][] = ['label' => 'Form Threads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-thread-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'tagList'=>$tagList
    ]) ?>

</div>
