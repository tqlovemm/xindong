<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\CreditValue */

$this->title = 'Create Credit Value';
$this->params['breadcrumbs'][] = ['label' => 'Credit Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

if(Yii::$app->session->hasFlash("empty")):
?>
<div class="alert alert-warning">
    <?=Yii::$app->session->getFlash("empty")?>
</div>
<?php endif;?>

<div class="credit-value-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
