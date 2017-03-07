<?php $this->beginContent("@app/themes/basic/layouts/main.php");?>
    <div class="member">
        <?=$this->render('../layouts/header')?><!--头部导航-->
        <div style="margin-bottom: 60px;">
            <?= $content; ?>
        </div>
        <?=$this->render("../layouts/footer")?><!--底部导航栏-->
    </div>
<?=$this->render("../layouts/list_01")?><!--侧边栏-->
<?php $this->endContent(); ?>
