<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\app\models\TurnOverCardPalace */

$this->title = 'Create Turn Over Card Palace';
$this->params['breadcrumbs'][] = ['label' => 'Turn Over Card Palaces', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turn-over-card-palace-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
