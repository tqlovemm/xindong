<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use shiyang\infinitescroll\InfiniteScrollPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '我的日志';
$this->params['breadcrumbs'][] = $this->title;

$user = Yii::$app->user->identity;
?>
<div class="social-wrapper row">
    <div id="social-container">
        <div class="col-xs-12 col-sm-8 col-md-8" id="content">
            <div class="post-index">
                <h1><?= Html::encode($this->title) ?></h1>
                <p>
                    <?= Html::a('创建日志', ['create'], ['class' => 'btn btn-success']) ?>

                </p>
            </div>
            <?php if (!empty($posts)): ?>
                <?php foreach($posts as $post): ?>
                    <article class="item widget-container fluid-height social-entry" id="<?= $post['id'] ?>">
                        <header class="widget-content padded">
                            <h3 style="margin-top: 0;"><?= Html::a(Html::encode($post['title']), ['/home/post/view', 'id' => $post['id']]) ?></h3>
                        </header>
                        <div class="widget-footer">
                            <div class="footer-detail">
                                &nbsp;
                                <a href="<?= Url::toRoute(['/home/post/delete', 'id' => $post['id']]) ?>" data-clicklog="delete" onclick="return false;" title="确定删除">
                                    <span class="glyphicon glyphicon-trash"></span> 删除
                                </a>
                                &nbsp;
                                <span class="item-line"></span>
                                <a href="<?= Url::toRoute(['/home/post/update', 'id' => $post['id']]) ?>">
                                    <span class="glyphicon glyphicon-edit"></span> 更新
                                </a>
                                &nbsp;fewfefe
                                <span class="item-line"></span>
                                <span class="glyphicon glyphicon-time"></span> <?= Yii::$app->formatter->asRelativeTime($post['created_at']) ?>
                            </div>
                        </div>

                    </article>
                <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"16"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"������","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>

            <?php endforeach; ?>
            <?php else: ?>
                <div class="no-data-found">
                    <i class="glyphicon glyphicon-folder-open"></i>
                    没有数据展示
                </div>
            <?php endif; ?>
        </div>
        <?= InfiniteScrollPager::widget([
               'pagination' => $pages,
               'widgetId' => '#content',
        ]);?>
    </div>
</div>
