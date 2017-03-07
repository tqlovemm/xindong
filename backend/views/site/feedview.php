<?php
use yii\helpers\Html;
?>

<table class="table table-bordered table-hover" align="center">
    <tr>
<?php

foreach($feedones as $feedone):
?>

    <tr>
        <th width="100">反馈会员：</th><td width="900"><?=$feedone['created_by']?></td>
    </tr> <tr>
        <th>反馈时间：</th><td><?=date('Y-m-d H:i:s',$feedone['created_at'])?></td>
    </tr> <tr>
        <th>反馈标题：</th><td><?=Html::encode($feedone['title'])?></td>
    </tr> <tr>
        <th>反馈内容：</th><td style="word-break:break-all"><?=Html::encode($feedone['content'])?></td>
    </tr>




<?php
endforeach;
?>

</table>

