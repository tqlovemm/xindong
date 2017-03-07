<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\seventeen\models\SeventeenWeiUser */

$this->title = 'Create Seventeen Wei User';
$this->params['breadcrumbs'][] = ['label' => 'Seventeen Wei Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seventeen-wei-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
