<?php

$this->title = '心动故事';

$this->registerCss('

.dating-adv{width:100%;height:6em;background-position:left;background-size:90%;background-repeat:no-repeat;padding:1px 0 0 0 ;}
.dating-adv h2{color:white;margin-top:15px;margin-bottom:0;padding-left:.4em;}
.dating-adv h5{color:white;padding-left:1em;margin-top:.1em;}
.dating-min{width:100%;height:5em;background-position:left;background-size:60%;background-repeat:no-repeat;padding:1px 0 0 0 ;}
.dating-min{color:#F04450;}
.dating-min h3{padding-left:.5em;}
.album-view{background-color: white;border-bottom:1px solid #c6c6c6;padding:10px 10px;width:48%;float:left;margin:0 1% 1% 0;}

.red{color:red;}
.blue{color:blue;}
.share{display:none;}

.bl_more a{background-color: white;padding:10px;;display: block;margin-top: 5px;text-align: center;cursor: pointer;}
.bl_more:before{clear:both;}
@media (max-width: 786px) {

    .hear-top{margin-top:10px;}
    .album-view{width:100%;margin:0;float:none;}
}

');
?>

<div class="container">

    <div class="row">

        <div class="col-md-3 suo-xia">

            <?= $this->render('../layouts/dating_left')?>

        </div>
        <div class="col-md-9">

            <div class="container-fluid suo-xia">


                <div class="row hear-top"  id="more" style="min-height: 500px;">
                    <div class="album-view single_item">

                        <div class="all-hear"></div>
                    </div>

                    <div class="clearfix bl_more get_more text-danger"><a>加载更多</a></div>
                </div>

                <script type="text/javascript">
                    $(function() {
                        $('#more').more({'address': '/site/more?status=1&data=weekly'});
                    });
                </script>

            </div>

        </div>

    </div>

</div>


