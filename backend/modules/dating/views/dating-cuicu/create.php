<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\member\models\DatingCuicu */

$this->title = 'Create Dating Cuicu';
$this->params['breadcrumbs'][] = ['label' => 'Dating Cuicus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dating-cuicu-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
