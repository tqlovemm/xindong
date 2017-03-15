<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "觅约信息";
$this->params['breadcrumbs'][] = $this->title;
$this->registerCss('
    .pagination{display:block;}
');

?>
<p>
   
</p>
<div class="album-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_search', ['model' => $searchModel]); ?>
    <?= ListView::widget([
        'layout' => "{items}\n{pager}",
        'dataProvider' => $dataProvider,

        'itemView' => '_album',
        'options' => [
            'tag' => 'ul',
            'class' => 'album-all list-inline'
        ],
        'itemOptions' => [
            'class' => 'album-item list-unstyled',
            'tag' => 'li'
        ]
    ]); ?>

</div>
<script>


    function dating_toggle(id,con){

        var cons = $(con);
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function stateChanged()
        {
            if (xhr.readyState==4 || xhr.readyState=="complete")
            {
                cons.html(xhr.responseText);

            }
        };
        xhr.open('get','/dating/dating/dating-hide?id='+id);
        xhr.send(null);


    }

</script>
