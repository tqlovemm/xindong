<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\show\models\SeekSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'In ID照';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCss('
    div .item{float:left;margin:5px 10px;width:150px;height:380px;text-align:center;}
    div .item a img{max-width: 100%;height: 60%;}
    div .item p{line-height:23px;color:green;text-align:center;height: 70px;margin:0;}
    div .item h4{margin-bottom:3px;color:black;text-align:center;}
    div .item .btn-xs{margin:auto;}


    .sorter li{width: 50px !important;font-size:14px;list-style: none;}
    .sorter li a{border-radius: 30%;border: 1px solid #cecece;padding: 3px 10px;}

    .sorter li a{background-color: #E7826B;color: white;}
    .sorter li a:hover{background-color: #e75345;}

     @media (max-width: 768px) {

        div .item{width: auto;float: none;margin: 10px 0;  height: auto;}
        div .item p{height: auto;}
        div .item a img{height:auto;}
        .seeks-search:after{content:'.';visibility: hidden;display:block;height: 0;clear: both;}
        .form-group input{width: 55% !important;}
    }
');
?>
<?php

$this->registerJsFile('@web/js/lightbox/js/lightbox.min.js', ['depends' => ['yii\web\JqueryAsset']]);
$this->registerCssFile('@web/js/lightbox/css/lightbox.css');
?>
<style>



</style>
<div class="seeks-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

<?=ListView::widget([

    'dataProvider' => $dataProvider,
    'itemOptions' => ['class' => 'item'],
    'layout' => "{sorter}\n{items}\n{pager}", // Add sorter to layout because it's turned off by default
    'sorter' => [
            'attributes'=>['created_at',]
    ],
    'itemView' => function ($model, $key, $index, $widget) {

        $description = mb_substr($model->thumb,0,25,"utf-8");
        $time = date('Y-m-d',$model->created_at);
        $html = <<<Html
                <a href="{$model->path}"  data-lightbox="image-1">
                   <img class="img-responsive center-block" src="{$model->path}">
                </a>

                <h4>{$model->name}</h4>
                <p>{$description}</p>
                <time style="color: orangered"><i class="glyphicon glyphicon-time"></i> $time</time>
                <a class="btn btn-default btn-xs" href="/index.php/show/ingids/view?id={$model->id}">更多信息</a>
Html;
        return $html;

    },

]);

?>



</div>
