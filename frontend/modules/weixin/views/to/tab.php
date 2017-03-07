<?php

$this->registerCss("
    nav,footer{display:none;}
");
?>
<div class="row" style="margin: 0;">
    <div class="col-md-5">
        <textarea title="1" id="text1" class="form-control pull-left" rows="15"></textarea>
    </div>
    <div class="col-md-1" style="padding: 0;">
        <button id="transfer" class="btn btn-success" style="line-height: 100px;">翻译</button>
        <button id="clear" class="btn btn-danger" style="line-height: 100px;">清空</button>
    </div>
    <div class="col-md-6">
        <textarea title="2" id="text2"  class="form-control pull-left" rows="15"></textarea>
    </div>
</div>

<script type="text/javascript">

    String.prototype.stripHTML = function() {
        var reTag = /<[^>]*>/g;
        return this.replace(reTag,"");
    };


    $('#transfer').on('click',function () {

        $('#text2').html($('#text1').val().stripHTML());
    });
    $('#clear').on('click',function () {

        $('#text1').val('');
    });

</script>
