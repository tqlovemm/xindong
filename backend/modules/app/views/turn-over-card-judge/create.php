<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\app\models\TurnOverCardJudge */

$this->title = 'Create Turn Over Card Judge';
$this->params['breadcrumbs'][] = ['label' => 'Turn Over Card Judges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turn-over-card-judge-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
