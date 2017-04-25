<?php
$wechat = Yii::$app->request->get('wechat');
$this->title = $wechat." 入会收款记录";
$this->registerCssFile('@web/js/lightbox/css/lightbox.css');
$this->registerJsFile('@web/js/lightbox/js/lightbox.min.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);
$this->registerCss("
    .table thead tr{background-color: #ddd;}
    .table thead tr th{border:1px solid #eee;text-align:center;}
    .table tr td{border:1px solid #eee;text-align:center;}
    .follow{margin-bottom:0;}
    .follow li{list-style: none;}
    .main-header,.main-sidebar,footer{display:none;}
    .content-wrapper{margin-left:0;}
");
?>
<div class="col-md-6">
    <ul class="timeline">
        <!-- timeline time label -->
        <li class="time-label">
              <span class="bg-red"><?=date('Y年m月d日',Yii::$app->request->get('time'))?></span>
        </li>
        <!-- /.timeline-label -->
        <!-- timeline item -->
        <?php foreach ($model as $item):
            $user = \backend\models\User::findOne($item['created_by'])->username .' '.\backend\models\User::findOne($item['created_by'])->nickname;
            $payment_to = $item['payment_to']==1?"收款专用号":"客服号";
            ?>
        <li>
            <i class="fa fa-user bg-aqua bg-blue"></i>
            <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> <?=date('Y-m-d H:i',$item['created_at'])?></span>

                <h3 class="timeline-header"><a href="#"><?=$user?></a> 记录一条入会付款数据</h3>

                <div class="timeline-body">
                    <table class="table table-bordered" style="margin-bottom: 10px;">
                        <thead>
                        <tr>
                            <th>收款渠道</th>
                            <th>收款金额</th>
                            <th>收款账号</th>
                            <th>会员等级</th>
                            <th>入会地区</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?=$item['channel']?></td>
                            <td><?=$item['payment_amount']?></td>
                            <td><?=$payment_to?></td>
                            <td><?=$item['vip']?></td>
                            <td><?=$item['join_address']?></td>
                        </tr>
                        </tbody>
                    </table>
                    <a href="<?=Yii::$app->params['test'].$item['payment_screenshot']?>" data-lightbox="s" data-title="d">
                        <img style="max-width: 200px;margin-bottom: 10px;" src="<?=Yii::$app->params['test'].$item['payment_screenshot']?>">
                    </a>

                    <p><strong style="color: #000;">备注：</strong><?=$item['remarks']?></p>
                </div>
                <div class="timeline-footer">
                    <a class="btn btn-primary btn-xs">Read more</a>
                    <a class="btn btn-danger btn-xs">Delete</a>
                </div>
            </div>
        </li>
        <?php endforeach;?>
 <!--       <li>
            <i class="fa fa-user bg-aqua"></i>

            <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request</h3>
            </div>
        </li>


        <li>
            <i class="fa fa-comments bg-yellow"></i>

            <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                <div class="timeline-body">
                    Take me to your leader!
                    Switzerland is small and neutral!
                    We are more like Germany, ambitious and misunderstood!
                </div>
                <div class="timeline-footer">
                    <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                </div>
            </div>
        </li>


        <li class="time-label">
              <span class="bg-green">
                3 Jan. 2014
              </span>
        </li>


        <li>
            <i class="fa fa-camera bg-purple"></i>

            <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                <div class="timeline-body">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                </div>
            </div>
        </li>


        <li>
            <i class="fa fa-video-camera bg-maroon"></i>

            <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> 5 days ago</span>

                <h3 class="timeline-header"><a href="#">Mr. Doe</a> shared a video</h3>

                <div class="timeline-body">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tMWkeBIohBs" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="timeline-footer">
                    <a href="#" class="btn btn-xs bg-maroon">See comments</a>
                </div>
            </div>
        </li>


        <li>
            <i class="fa fa-clock-o bg-gray"></i>
        </li>-->
    </ul>
</div>