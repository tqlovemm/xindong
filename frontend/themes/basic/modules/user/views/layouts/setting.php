<?php
use yii\bootstrap\Nav;

$this->title=Yii::$app->user->identity->username.' - '.Yii::t('app', 'Setting');
$this->registerCss("

@media (max-width:420px){
  .padding-md{padding:20px 0 !important;}
  .container-fluid{padding:0;}
}


");
?>
<?php $this->beginContent('@app/modules/user/views/layouts/user.php'); ?>
      <div class="col-xs-12 col-sm-4 col-md-2">

              <?= Nav::widget([
                  'encodeLabels' => false,
                  'items' => [
                      ['label' => '<span class="glyphicon glyphicon-home"></span> 个人档', 'url' => ['setting/profile']],
                      ['label' => '<span class="glyphicon glyphicon-user"></span> 账户信息', 'url' => ['setting/account']],
                      ['label' => '<span class="glyphicon glyphicon-cog"></span> 密码修改', 'url' => ['setting/security']],
                      ['label' => '<span class="glyphicon glyphicon-search"></span> 交友要求', 'url' => ['setting/mark']],
                  ],
                  'options' => ['class' => 'nav-pills nav-stacked']
              ])

              ?>

      </div>

      <div class="col-xs-12 col-sm-8 col-md-10">
        <?= $content; ?>
      </div>
<?php $this->endContent(); ?>