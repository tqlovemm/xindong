<?php
use yii\helpers\Url;
$id = Yii::$app->request->get('id');
?>

<!-- Large modal -->
<div class="modal fade" id="avatarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">系统头像</h4>
      </div>
      <div class="modal-body">
        <?php for ($name=1; $name <= 20; $name++) : ?>

            <a href="<?= Url::toRoute(['/dating/heart-week/avatar', 'name' => $name,'id'=>$id]) ?>" onclick="return false;" data-clicklog="selectAvatar">
                <img style="width: 100px;height: 100px;" src="<?='/uploads/dating/avatar/default/' . $name.'.jpg'?>" alt="User avatar" class="img-thumbnail">
            </a>
        <?php endfor; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
      </div>
    </div>
  </div>
</div>
<?php
$js = "
  $('[data-clicklog=selectAvatar]').on('click', function(){
    jQuery.ajax({
        url: $(this).attr('href'),
        success: function() {
          $('#avatarModal').modal('hide');
          window.location.reload();
        }
    });
  });
";
$this->registerJs($js);
?>
