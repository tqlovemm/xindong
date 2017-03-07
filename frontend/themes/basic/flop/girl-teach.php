<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/18
 * Time: 13:15
 */
$this->title="十三平台男生档案";

use yii\web\View;

$this->registerCss("

    .navbar,footer,.weibo-share{display:none;}
    .focus{ width:100%; height:100%;  margin:0 auto; position:relative; overflow:hidden;   }
	.focus .hd{ width:100%; height:11px;  position:absolute; z-index:1; bottom:13%; text-align:center;  }
	.focus .hd ul{ display:inline-block; height:10px; padding:3px 5px; background-color:rgba(255,255,255,0.7);
		-webkit-border-radius:5px; -moz-border-radius:5px; border-radius:5px; font-size:0; vertical-align:top;
	}
	.focus .hd ul li{ display:inline-block; width:10px; height:10px; -webkit-border-radius:5px; -moz-border-radius:5px; border-radius:5px; background:#8C8C8C; margin:0 5px;  vertical-align:top; overflow:hidden;   }
	.focus .hd ul .on{ background:#FE6C9C;  }

	.focus .bd{ position:relative; z-index:0; }
	.focus .bd li img{ width:100%;background:url(images/loading.gif) center center no-repeat;  }
	.focus .bd li a{ -webkit-tap-highlight-color:rgba(0, 0, 0, 0); /* 取消链接高亮 */  }

");

?>

<?php $this->registerJsFile("@web/js/TouchSlide.1.1.source.js",['position' => View::POS_HEAD]);?>
<div class="container-fluid">

    <div class="row" style="position: relative;">
        <a href="girl" style="width:60px;height:60px;cursor: pointer;background-color: rgba(128, 128, 128, 0.4);text-align:center;line-height: 60px;border-radius: 50%;position: fixed;right:5%;top:5%;z-index: 99999;font-size: 18px;">跳过</a>
        <!-- 本例主要代码 Start ================================ -->
        <div id="focus" class="focus">
            <div class="hd">
                <ul></ul>
            </div>
            <div class="bd">
                <ul>
          <!--          <li><img src="<?/*=Yii::getAlias('@web')*/?>/images/flop/1.jpg" /></li>-->
                    <li><img src="<?=Yii::getAlias('@web')?>/images/flop/2.jpg" /></li>
                    <li><img src="<?=Yii::getAlias('@web')?>/images/flop/3.jpg" /></li>
                    <li><img src="<?=Yii::getAlias('@web')?>/images/flop/4.jpg" /></li>
                    <li><img src="<?=Yii::getAlias('@web')?>/images/flop/5.jpg" /></li>
                    <li>
                        <div style="position: relative;">

                            <img src="<?=Yii::getAlias('@web')?>/images/flop/6.jpg" />
                            <a href="girl" style="position: absolute;width:200px;height:60px;background-color: transparent;z-index: 9999;bottom:16%;left:50%;margin-left: -100px;"></a>

                        </div>

                    </li>

                </ul>
            </div>
        </div>
        <script type="text/javascript">
            TouchSlide({
                slideCell:"#focus",
                titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
                mainCell:".bd ul",
                effect:"left",
                autoPlay:false,//自动播放
                autoPage:true, //自动分页
                switchLoad:"_src" //切换加载，真实图片路径为"_src"
            });
        </script>
        <!-- 本例主要代码 End ================================ -->

    </div>

</div>