<?php

$style = $model['style'];
$title = $model['name'];
$content = $model['content'];
$this->registerCss("

        p{margin:0;}
        .style p{margin:0;}
        .col-md-12 .col-md-12{padding:0}

        .w0{
            width: 0px;
            margin: auto;
            border-bottom-width: 0.8em;
            border-bottom-style: solid;
            border-bottom-color: rgb(222, 83, 83);
            border-top-color: rgb(0, 187, 236);
            box-sizing: border-box;
            height: 10px;
            color: inherit;
            padding: 0px;
            border-left-width: 0.8em !important;
            border-left-style: solid !important;
            border-left-color: transparent !important;
            border-right-width: 0.8em !important;
            border-right-style: solid !important;
            border-right-color: transparent !important;
        }
        .w1{width: 0px;
            height: 0px;
            border-left-width: 27px;
            border-left-style: solid;
            border-left-color: transparent;
            border-right-width: 27px;
            border-right-style: solid;
            border-right-color: transparent;
            display: block;
            margin: -30px auto 29px;
            border-top-width: 11px;
            border-top-style: solid;
            border-top-color: rgb(222, 84, 84);
            }
        .w2{float: left;
            margin-left: -7px;
            display: block;}
        .style_01,.style_02,.style_03,.style_04,.style_05,.style_06,.style_07,.style_08,.style_09
        .style_10,.style_11,.style_12,.style_13,.style_14,.style_15,.style_16,.style_17,.style_18
        {margin:20px 0;}

        .style_01 .style{  padding: 0.6em;
                    line-height: 1.2em;
                    font-size: 1.2em;
                    box-sizing: border-box;
                    color: white;
                    border-color: rgb(61, 161, 233);
                    background-color: rgb(222, 83, 83);
                    border-top-left-radius: 4px;
                    border-top-right-radius: 4px;
                    border-bottom-right-radius: 4px;
                    border-bottom-left-radius: 4px;
                    margin: 0;}
        .style_02 .style{max-width: 100%;
                white-space: normal;
                margin: 5px 0px 0px;
                border-color: rgb(222, 84, 84);
                border-style: none none none solid;
                padding: 10px;
                line-height: 25px;
                color: rgb(153, 153, 153);
                background-color: rgb(243, 243, 243);
                box-shadow: rgb(153, 153, 153) 1px 1px 2px;
                border-left-width: 10px;
                box-sizing: border-box !important;
                word-wrap: break-word !important;}
        .style_03 .style{
                 font-size: 14px;
                line-height: 22.39px;
                margin: 10px 0px;
                padding: 15px 20px 15px 45px;
                outline: 0px;
                border: 0px currentcolor;
                color: rgb(62, 62, 62);
                vertical-align: baseline;
                background-image: url(http://www.wx135.com/img/bg/left_quote.jpg);
                background-color: rgb(241, 241, 241);
                box-sizing: border-box;
                background-position: 1% 5px;
                background-repeat: no-repeat no-repeat;
          }


        .style_04{
                padding: 30px 20px;
                border-top-width: 2px;
                border-top-style: solid;
                border-color: rgb(222, 84, 84);
                border-bottom-width: 2px;
                border-bottom-style: solid;
                color: rgb(97, 97, 97);
                background-size: 17%;
                line-height: 1.4;
                background-position: 50% 0%;
                background-repeat: no-repeat no-repeat;}
        .style_05{
                margin: 1em auto;
                padding: 1em 0em;
                border-style: none;}
        .style_05 .style{
                    padding: 16px;
                    -webkit-box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.5);
                    -moz-box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.5);
                    -o-box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.5);
                    box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.5);
                    width: 100%;
                    font-size: 14px;
                    line-height: 1.4;}
      .style_06{
                padding: 0px 5px;
                line-height: 10px;
                color: inherit;
                border: 2px solid rgb(221, 84, 84);}
        .style_06 .style{    margin: 15px 10px;
                            padding: 0px;
                            line-height: 2em;
                            color: rgb(62, 62, 62);
                            font-size: 14px;
                            border-top-color: rgb(221, 84, 84);}
        .hidden-line_1{margin: -8px 21.6719px 0px;
                    padding: 0px;
                    color: inherit;
                    height: 8px;
                    border-color: rgb(0, 187, 236);
                    background-color: rgb(254, 254, 254);}
        .hidden-line_2{margin: 0px 21.6719px -4px;
                        padding: 0px;
                        color: inherit;
                        text-align: right;
                        height: 10px;
                        border-color: rgb(0, 187, 236);
                        background-color: rgb(254, 254, 254);}

        .style_07 .style{margin: -1px 0px 0px;
                        padding: 0px;
                        color: rgb(0, 0, 0);
                        font-size: 16px;
                        min-height: 40px;
                        visibility: visible;
                        height: 40px;
                        line-height: 40px;
                        border-radius: 4px;
                        text-align: center;
                        box-shadow: rgb(190, 190, 190) 0px 3px 5px;
                        background: rgb(238, 239, 239);}
                        section span{line-height:1em !important;}

    ");

if ($style == 1):?>
    <section class="style_01">
        <div class="w0"><br></div>
        <div class="style">
            <?= $title ?>
        </div>
    </section>
<?php elseif ($style == 2):; ?>
    <section class="style_02">
        <div class="style"><?= $title ?></div>
    </section>
<?php elseif ($style == 3):; ?>
    <section class="style_03">
        <div class="style"><?= $title ?></div>
    </section>
<?php elseif ($style == 4):; ?>
    <section class="style_04">
        <span class="w1"></span>
        <div class="style"><?= $title ?></div>
    </section>
<?php elseif ($style == 5):; ?>
    <section class="style_05">
        <span class="w2">
            <section
                style="min-height: 33px;color: rgb(255, 255, 255);text-align: center;background-color: rgb(217, 77, 77);line-height: 1.5;font-size: 15px;margin-right: 10px;padding: 5px 8px;min-width: 75px;">
                <?= $title ?>
            </section>
            <img style="display: block;width: 7px;" src="<?= Yii::getAlias('@web') ?>/images/dating/yin.jpg"
                 data-type="gif" data-ratio="0.8571428571428571" data-w="7">
        </span>
        <div class="style"><?= $content ?></div>
    </section>
<?php elseif ($style == 6):; ?>
    <section class="style_06">

        <div class="hidden-line_1"></div>
        <div class="style">
            <?= $title ?>
        </div>
        <div class="hidden-line_2"></div>

    </section>
<?php elseif ($style == 7):; ?>
    <section class="style_07">
        <div class="style">
            <?= $title ?>
        </div>
    </section>
<?php elseif ($style == 8):; ?>
    <fieldset style="margin-top: 1.5em; margin-bottom: 1.5em; border-color: currentcolor; max-width: 100%;">
        <section
            style="margin: 0px; padding: 0px; color: rgb(68, 68, 68); line-height: 25px; height: 1em; max-width: 100%;">
            <section class="wxqq-borderTopColor wxqq-borderLeftColor"
                     style="margin: 0px; padding: 0px; border-color: rgb(221, 84, 84) rgb(0, 187, 236) rgb(0, 187, 236) rgb(221, 84, 84); width: 1.5em; height: 16px; border-top-width: 0.4em; border-left-width: 0.4em; border-top-style: solid; border-left-style: solid; float: left; max-width: 100%;"></section>
            <section class="wxqq-borderTopColor wxqq-borderRightColor"
                     style="margin: 0px; padding: 0px; border-color: rgb(221, 84, 84) rgb(221, 84, 84) rgb(0, 187, 236) rgb(0, 187, 236); width: 1.5em; height: 16px; border-top-width: 0.4em; border-right-width: 0.4em; border-top-style: solid; border-right-style: solid; float: right; max-width: 100%;"></section>
        </section>
        <section class="wxqq-borderTopColor wxqq-borderRightColor wxqq-borderBottomColor wxqq-borderLeftColor"
                 style="margin: -0.8em 0.1em -0.8em 0.2em; padding: 0.8em; border-radius: 0.3em; border: 1px solid rgb(221, 84, 84); border-image-source: initial; border-image-slice: initial; border-image-width: initial; border-image-outset: initial; border-image-repeat: initial; max-width: 100%;">
            <?= $title ?>
        </section>
        <section
            style="margin: 0px; padding: 0px; color: rgb(68, 68, 68); line-height: 25px; height: 1em; max-width: 100%;">
            <section class="wxqq-borderBottomColor wxqq-borderLeftColor"
                     style="margin: 0px; padding: 0px; border-color: rgb(0, 187, 236) rgb(0, 187, 236) rgb(221, 84, 84) rgb(221, 84, 84); width: 1.5em; height: 16px; border-bottom-width: 0.4em; border-left-width: 0.4em; border-bottom-style: solid; border-left-style: solid; float: left; max-width: 100%;"></section>
            <section class="wxqq-borderRightColor wxqq-borderBottomColor"
                     style="margin: 0px; padding: 0px; border-color: rgb(0, 187, 236) rgb(221, 84, 84) rgb(221, 84, 84) rgb(0, 187, 236); width: 1.5em; height: 16px; border-right-width: 0.4em; border-bottom-width: 0.4em; border-right-style: solid; border-bottom-style: solid; float: right; max-width: 100%;"></section>
        </section>
    </fieldset>
<?php elseif ($style == 9): ?>
    <section class="135editor" data-id="53787" style="margin: 0px; padding: 0px; border: 0px none;">
        <section class="layout" style="margin: 0.8em auto 0.3em; padding: 0px; border: none;">
            <section class="135brush" data-brushtype="text"
                     style="margin: 0px auto; padding: 9px 4px 14px; color: rgb(222, 84, 84); font-size: 20px; letter-spacing: 3px; text-align: center; border: 4px solid rgb(222, 84, 84); border-radius: 8px;"><?= $title ?></section>
            <section
                style="margin: 0px auto; padding: 0px; width: 0px; border-top-width: 0.6em; border-top-style: solid; border-bottom-color: rgb(222, 84, 84); border-top-color: rgb(222, 84, 84); height: 10px; border-left-width: 0.7em !important; border-left-style: solid !important; border-left-color: transparent !important; border-right-width: 0.7em !important; border-right-style: solid !important; border-right-color: transparent !important;"></section>
        </section>
        <section style="margin: 0px; padding: 0px; width: 0px; height: 0px; clear: both;"></section>
    </section>
<?php elseif ($style == 10): ?>
    <section class="article135" style="margin: 0px; padding: 0px;">
        <section class="135editor" data-id="50638" data-color="rgb(239, 112, 96)" data-custom="rgb(239, 112, 96)"
                 style="margin: 0px; padding: 0px; border: 0px none;">
            <section class="layout" data-width="100%"
                     style="margin: 0px auto; padding: 0px; width: 100%; text-align: center;">
                <section data-width="100%"
                         style="margin: 15px 0px; padding: 0px; width: 100%; border-top-width: 2px; border-top-style: solid; border-color: rgb(239, 112, 96); border-bottom-width: 2px; border-bottom-style: solid; color: inherit; font-size: 14px; display: inline-block;">
                    <section class="135brush" data-style="line-height:24px;color:rgb(89, 89, 89); font-size:20px;"
                             style="margin: -15px 15px; padding: 30px; border-right-width: 2px; border-right-style: solid; border-color: rgb(239, 112, 96); border-left-width: 2px; border-left-style: solid; color: inherit;">
                        <?= $title ?>
                    </section>
                </section>
            </section>
        </section>
    </section>
<?php elseif ($style == 11): ?>
    <section data-id="84261" data-color="rgb(216, 40, 33)" data-custom="rgb(216, 40, 33)"
             style="margin: 10px 0; padding: 0px; border: 0px none;">
        <section class="layout" style="margin: 5px auto; padding: 0px; border: 0px;">
            <section style="margin: 0px; padding: 0px; height: 25px; color: inherit;">
                <section
                    style="margin: 0px; padding: 0px; height: 25px; width: 50px; float: left; border-top-width: 2px; border-top-style: solid; border-color: rgb(216, 40, 33); border-left-width: 2px; border-left-style: solid; color: inherit;"></section>
                <section
                    style="margin: 0px; padding: 0px; display: inline-block; color: rgb(216, 40, 33); clear: both; border-color: rgb(216, 40, 33);"></section>
            </section>
            <section class="135brush"
                     data-style="color: rgb(51, 51, 51); font-size: 1em; line-height: 1.75em; word-break: break-all; word-wrap: break-word; text-align: justify;"
                     style="margin: -0.8em 0.3em; padding: 0.8em; color: inherit;">
                <?= $title ?>
            </section>
            <section style="margin: 0px; padding: 0px; height: 25px; color: inherit;">
                <section
                    style="margin: 0px; padding: 0px; height: 25px; width: 50px; float: right; border-bottom-width: 2px; border-bottom-style: solid; border-color: rgb(216, 40, 33); border-right-width: 2px; border-right-style: solid; color: inherit;"></section>
            </section>
        </section>
        <section style="margin: 0px; padding: 0px; width: 0px; height: 0px; clear: both;"></section>
    </section>
<?php elseif ($style == 12): ?>
    <section class="wxqq-borderTopColor wxqq-borderRightColor wxqq-borderBottomColor wxqq-borderLeftColor"
             style="margin: 20px 0; padding: 8px 16px; font-family: inherit; font-size: 1em; font-weight: inherit; line-height: 25.6px; text-align: center; border: 1px solid rgb(221, 84, 84); box-shadow: rgb(165, 165, 165) 5px 5px 2px; text-decoration: inherit; color: rgb(51, 51, 51);">
        <section class="wxqq-borderTopColor"
                 style="margin: -1.2em 0px 0px; padding: 0px; border-style: none; border-width: initial; border-top-color: rgb(221, 84, 84);">
            <span class="wxqq-bg"
                  style="margin: 0px; padding: 4px 8px; display: inline-block; color: rgb(255, 255, 255); font-size: 1em; line-height: 1.4; font-family: inherit; font-weight: inherit; text-decoration: inherit; border-color: rgb(0, 187, 236); background-color: rgb(221, 84, 84);"><section
                    class="wxqq-borderTopColor"
                    style="margin: 0px; padding: 0px; border-top-color: rgb(221, 84, 84);"><?= $title ?></section></span>
        </section>
        <section class="wxqq-borderTopColor"
                 style="margin: 0px; padding: 16px; font-size: 1em; line-height: 1.4; font-family: inherit; border-top-color: rgb(221, 84, 84);">
            <section class="wxqq-borderTopColor"
                     style="margin: 0px; padding: 0px; text-align: left; border-top-color: rgb(221, 84, 84);">
                <?= $content ?>
            </section>
        </section>
        <section style="margin: 0px; padding: 0px; width: 0px; height: 0px; clear: both;"></section>
    </section>
<?php elseif ($style == 13): ?>
    <blockquote class="wxqq-bg"
                style="margin-top:10px;margin-bottom: 0;  padding: 5px 15px; border: 0px currentcolor; font-family: 'Helvetica Neue', Helvetica, 'Hiragino Sans GB', 'Microsoft YaHei', Arial, sans-serif; font-size: 16px; border-radius: 5px 5px 0px 0px; text-align: center; color: rgb(255, 255, 255); line-height: 25px; font-weight: bold; max-width: 100%; background-color: rgb(221, 84, 84);">
        <?= $title ?>
    </blockquote>
    <blockquote class="wxqq-borderTopColor wxqq-borderRightColor wxqq-borderBottomColor wxqq-borderLeftColor"
                style="padding-right: 15px; padding-bottom: 20px; padding-left: 15px; border-width: 1px; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-color: rgb(221, 84, 84); color: rgb(0, 0, 0); font-family: 'Helvetica Neue', Helvetica, 'Hiragino Sans GB', 'Microsoft YaHei', Arial, sans-serif; font-size: 16px; border-radius: 0px 0px 5px 5px; line-height: 25px; max-width: 100%;">
        <?= $content ?>
    </blockquote>
<?php elseif ($style == 14): ?>
    <section data-id="2490" class="wxqq-borderTopColor"
             style="margin: 10px 0; padding: 0px; color: rgb(0, 0, 0); font-family: 'Helvetica Neue', Helvetica, 'Hiragino Sans GB', 'Microsoft YaHei', Arial, sans-serif; font-size: 16px; line-height: 25.6px; border-top-color: rgb(221, 84, 84);">
        <section class="wxqq-borderTopColor wxqq-borderRightColor wxqq-borderBottomColor wxqq-borderLeftColor"
                 style="margin: 0px; padding: 5px; border: 3px solid rgb(221, 84, 84);">
            <section class="wxqq-borderTopColor wxqq-borderRightColor wxqq-borderBottomColor wxqq-borderLeftColor"
                     style="margin: 0px; padding: 15px; border: 1px solid rgb(221, 84, 84); text-align: center; color: inherit;">
                <?= $title ?>
            </section>
        </section>
    </section>
<?php elseif ($style == 15): ?>
    <section class="wxqq-borderTopColor"
             style="margin: 10px 0; padding: 0px; font-family: 'Helvetica Neue', Helvetica, 'Hiragino Sans GB', 'Microsoft YaHei', Arial, sans-serif; font-size: 16px; line-height: 25.6px; border-width: 0px; border-style: none; border-top-color: rgb(222, 84, 84);">
        <section style="margin: 10px 0px; padding: 0px; text-align: center;">
            <section
                style="color: rgb(0, 0, 0); margin: 0px; padding: 0px; transform: rotate(0deg); display: inline-block;">
                <section
                    style="margin: 0px auto; padding: 0px; width: 25px; height: 25px; border-radius: 50%; display: table-cell; vertical-align: middle;">
                    <span class="wxqq-color"
                          style="margin: 0px; padding: 0px; color: rgb(222, 84, 84); font-size: 18px;">★</span>
                </section>
            </section>
            <section class="wxqq-borderTopColor wxqq-borderBottomColor"
                     style="margin: -16px 0px; padding: 20px 10px; border-top-width: 1px; border-top-style: solid; border-color: rgb(222, 84, 84) rgb(30, 178, 225); border-bottom-width: 1px; border-bottom-style: solid;">
                <?= $title ?>
            </section>
            <section
                style="color: rgb(0, 0, 0); margin: 0px; padding: 0px; transform: rotate(0deg); display: inline-block;">
                <section
                    style="margin: 0px auto; padding: 0px; width: 25px; height: 25px; border-radius: 50%; display: table-cell; vertical-align: middle;">
                    <span class="wxqq-color"
                          style="margin: 0px; padding: 0px; color: rgb(222, 84, 84); font-size: 18px;">★</span>
                </section>
            </section>
        </section>
    </section>
<?php elseif
($style == 16
): ?>
    <fieldset class="wxqq-borderTopColor wxqq-borderRightColor wxqq-borderBottomColor wxqq-borderLeftColor"
              style="margin: 20px 0;font-family: 'Helvetica Neue', Helvetica, 'Hiragino Sans GB', 'Microsoft YaHei', Arial, sans-serif; font-size: 16px; line-height: 25.6px; border-color: rgb(222, 84, 84);">
        <section class="wxqq-borderTopColor wxqq-borderRightColor wxqq-borderBottomColor wxqq-borderLeftColor"
                 style="margin: 0px; padding: 10px; max-width: 100%; border: 2px dashed rgb(222, 84, 84); border-image-slice: initial; border-image-width: initial; border-image-outset: initial; border-image-repeat: initial; border-image-source: none; text-align: inherit; font-family: inherit; font-size: 1em; text-decoration: inherit; word-wrap: break-word !important; background-color: rgb(244, 244, 244);">

            <?= $title ?>
        </section>
    </fieldset>
<?php elseif ($style == 17): ?>
    <section class="wx96Diy" data-source="bj.96weixin.com" style="margin: 10px 0;">
        <section class="96wx-bdtc"
                 style="border-width: 0px; border-style: none; border-top-color: rgb(207, 31, 58); padding: 0px;">
            <section class="96wx-bdc"
                     style="margin: 10px 0px; padding: 0px; border: 3px solid rgb(207, 31, 58); width: 100%; display: inline-block;">
                <section class="96wx-bdtc"
                         style="margin-top: -1px; margin-right: -1px; padding: 0px; float: left; width: 0px; height: 0px; border-top-width: 2em; border-top-style: solid; border-top-color: rgb(207, 31, 58); border-left-width: 0em; border-left-style: solid; border-left-color: transparent; border-right-width: 2em; border-right-style: solid; border-right-color: transparent;"></section>
                <section class="96wx-bdtc"
                         style="margin-top: -1px; margin-right: -1px; padding: 0px; float: right; clear: none; width: 0px; height: 0px; border-top-width: 2em; border-top-style: solid; border-top-color: rgb(207, 31, 58); border-left-width: 2em; border-left-style: solid; border-left-color: transparent; border-right-width: 0em; border-right-style: solid; border-right-color: transparent;"></section>
                <section style="margin: 0px; padding: 0px; clear: both;">
                    <section style="margin: 0px; padding: 10px 20px;">

                        <?= $title ?>
                    </section>
                </section>
                <section class="96wx-bdbc"
                         style="margin-left: -1px; margin-bottom: -1px; padding: 0px; float: left; width: 0px; height: 0px; border-bottom-width: 2em; border-bottom-style: solid; border-bottom-color: rgb(207, 31, 58); border-left-width: 0em; border-left-style: solid; border-left-color: transparent; border-right-width: 2em; border-right-style: solid; border-right-color: transparent;"></section>
                <section class="96wx-bdbc"
                         style="margin-left: -1px; margin-bottom: -1px; padding: 0px; float: right; clear: none; width: 0px; height: 0px; border-bottom-width: 2em; border-bottom-style: solid; border-bottom-color: rgb(207, 31, 58); border-left-width: 2em; border-left-style: solid; border-left-color: transparent; border-right-width: 0em; border-right-style: solid; border-right-color: transparent;"></section>
            </section>
        </section>
    </section>
<?php elseif ($style == 18): ?>
    <section class="wx96Diy" data-source="bj.96weixin.com"
             style="margin: 20px 0; padding: 0px; font-family: 'Helvetica Neue', Helvetica, 'Hiragino Sans GB', 'Microsoft YaHei', Arial, sans-serif; font-size: 16px; line-height: 28.4444px;">
        <section class="96wx-bdc"
                 style="margin: 0px; padding: 8px 16px; text-align: center; border: 1px solid rgb(207, 31, 58); border-image-source: initial; border-image-slice: initial; border-image-width: initial; border-image-outset: initial; border-image-repeat: initial; box-shadow: rgb(165, 165, 165) 5px 5px 2px; font-size: 1em; font-family: inherit; font-weight: inherit; text-decoration: inherit; background-color: rgb(239, 239, 239);">
            <section class="96wx-bdtc"
                     style="color: rgb(51, 51, 51); margin: -1.2em 0px 0px; padding: 0px; border-style: none; border-width: initial; border-top-color: rgb(207, 31, 58);"><span
                    class="96wx-bgc"
                    style="margin: 0px; padding: 4px 8px; display: inline-block; color: rgb(255, 255, 255); font-size: 1em; line-height: 1.4; font-family: inherit; font-weight: inherit; text-decoration: inherit; border-color: rgb(0, 187, 236); background-color: rgb(207, 31, 58);"><section
                        class="96wx-bdtc" style="margin: 0px; padding: 0px; border-top-color: rgb(207, 31, 58);">
                        <?= $title ?>
                    </section></span></section>
            <section class="wxqq-borderTopColor"
                     style="margin: 0px; padding: 16px; font-size: 1em; line-height: 1.4; font-family: inherit;">
                <section class="96wx-bdtc"
                         style="margin: 0px; padding: 0px; text-align: left; border-top-color: rgb(207, 31, 58);">

                    <?= $content ?>
                </section>
            </section>
        </section>
    </section>
<?php elseif ($style == 19): ?>
    <section class="wx96Diy cur" data-source="bj.96weixin.com"
             style="margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: 'Helvetica Neue', Helvetica, 'Hiragino Sans GB', 'Microsoft YaHei', Arial, sans-serif; font-size: 16px; line-height: 28.4444px;">
        <section class="96wx-bdtc"
                 style="margin: 0px; padding: 0px; border-width: 0px; border-style: none; border-top-color: rgb(207, 31, 58);">
            <section style="margin: 10px 0px; padding: 0px; text-align: center;">
                <section style="margin: 0px; padding: 0px; display: inline-block;">
                    <section class="96wx-bgc"
                             style="margin: 0px 0px -4px; padding: 10px; color: rgb(255, 255, 238); background-color: rgb(207, 31, 58);">
                        <section style="margin: 0px; padding: 10px; border: 1px solid rgb(255, 255, 255);">

                            <?= $title ?>
                        </section>
                    </section>
                    <section style="margin: 0px; padding: 0px; opacity: 0.8; display: inline-block;">
                        <section style="margin: 0px; padding: 0px;">
                            <section class="96wx-bdtc"
                                     style="margin: 0px; padding: 0px; width: 0px; float: left; border-top-width: 8px; border-top-style: solid; border-top-color: rgb(207, 31, 58); border-left-width: 18px; border-left-style: solid; border-left-color: transparent; border-right-width: 18px; border-right-style: solid; border-right-color: transparent;"></section>
                            <section class="96wx-bdtc"
                                     style="margin: 0px; padding: 0px; float: left; border-top-width: 12px; border-top-style: solid; border-top-color: rgb(207, 31, 58); border-left-width: 22px; border-left-style: solid; border-left-color: transparent; border-right-width: 22px; border-right-style: solid; border-right-color: transparent;"></section>
                            <section class="96wx-bdtc"
                                     style="margin: 0px; padding: 0px; float: left; border-top-width: 15px; border-top-style: solid; border-top-color: rgb(207, 31, 58); border-left-width: 25px; border-left-style: solid; border-left-color: transparent; border-right-width: 25px; border-right-style: solid; border-right-color: transparent;"></section>
                            <section class="96wx-bdtc"
                                     style="margin: 0px; padding: 0px; float: left; border-top-width: 12px; border-top-style: solid; border-top-color: rgb(207, 31, 58); border-left-width: 22px; border-left-style: solid; border-left-color: transparent; border-right-width: 22px; border-right-style: solid; border-right-color: transparent;"></section>
                            <section class="96wx-bdtc"
                                     style="margin: 0px; padding: 0px; float: left; border-top-width: 8px; border-top-style: solid; border-top-color: rgb(207, 31, 58); border-left-width: 18px; border-left-style: solid; border-left-color: transparent; border-right-width: 18px; border-right-style: solid; border-right-color: transparent;"></section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
<?php elseif ($style == 20): ?>

    <section class="wx96Diy cur" data-source="bj.96weixin.com"
             style="margin:10px 0; padding: 0px; font-family: 'Helvetica Neue', Helvetica, 'Hiragino Sans GB', 'Microsoft YaHei', Arial, sans-serif; font-size: 16px; line-height: 28.4444px;">
        <section 96weixin-id="22" class="96wx-bdtc"
                 style="margin: 0px; padding: 0px; border-width: 0px; border-style: none; border-top-color: rgb(222, 84, 84);">
            <section class="96wx-bdc"
                     style="margin: 0px; padding: 1px; border: 1px solid rgb(222, 84, 84); border-image-source: initial; border-image-slice: initial; border-image-width: initial; border-image-outset: initial; border-image-repeat: initial; font-size: 14px;">
                <section class="96wx-bdc"
                         style="margin: 0px; padding: 1px; border: 1px solid rgb(222, 84, 84); border-image-source: initial; border-image-slice: initial; border-image-width: initial; border-image-outset: initial; border-image-repeat: initial;">
                    <section class="96wx-bdc" data-style="line-height:24px;color:rgb(89, 89, 89); font-size:14px"
                             style="margin: 0px; padding: 15px; border: 1px solid rgb(222, 84, 84); border-image-source: initial; border-image-slice: initial; border-image-width: initial; border-image-outset: initial; border-image-repeat: initial;">
                        <section style="margin: 15px; padding: 0px;">

                            <?= $title ?>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
<?php elseif ($style == 21): ?>
    <section class="wxqq-borderTopColor"
             style="color: rgb(0, 0, 0); font-size: 16px; font-family: 微软雅黑; margin: 10px 0; padding: 0px; border-width: 0px; border-top-color: rgb(221, 84, 84);">
        <section class="wxqq-borderTopColor"
                 style="margin: 0px 0px 0px 1em; padding: 0px; line-height: 1.4; border-top-color: rgb(221, 84, 84);">
            <span class="wxqq-bg"
                  style="margin: 0px; padding: 3px 8px; display: inline-block; border-radius: 4px; color: rgb(255, 255, 255); font-size: 1em; font-family: inherit; font-weight: inherit; text-align: inherit; text-decoration: inherit; border-color: rgb(0, 187, 236); background-color: rgb(221, 84, 84);"><section
                    class="wxqq-borderTopColor"
                    style="margin: 0px; padding: 0px; border-top-color: rgb(221, 84, 84);"><?= $title ?></section></span>
        </section>
        <section
            style="margin: -11px 0px 0px; padding: 22px 16px 16px; border: 1px solid rgb(192, 200, 209); color: rgb(51, 51, 51); font-size: 1em; font-family: inherit; font-weight: inherit; text-align: inherit; text-decoration: inherit; background-color: rgb(239, 239, 239);">
            <section class="wxqq-borderTopColor" style="margin: 0px; padding: 0px; border-top-color: rgb(221, 84, 84);">
                <?= $content ?>
            </section>
        </section>
    </section>
<?php elseif
($style == 22
): ?>
    <section style="margin: 20px 0; padding: 0px; border: 0px none;">
        <section
            style="margin: 1.5em auto;display: inline-block; border: 0px rgb(216, 40, 33); border-image-source: none; width: 100%; color: rgb(62, 62, 62); line-height: 25px; word-wrap: break-word !important;">
            <section
                style="margin: 0px 0px 0px -0.5em; padding: 0px; max-width: 100%; line-height: 1.4; word-wrap: break-word !important;">
                <section
                    style="margin: 0px; padding: 3px 8px; display: inline-block; max-width: 100%; border-color: rgb(0, 0, 0); border-radius: 4px; color: rgb(255, 255, 255); font-size: 1em; transform: rotate(-10deg); transform-origin: 0% 100% 0px; word-wrap: break-word !important; background-color: rgb(216, 40, 33);">
                    <?= $title ?>
                </section>
            </section>
            <section class="135brush" data-style="line-height:24px;color:rgb(89, 89, 89); font-size:14px"
                     style="margin: -24px 0px 0px; padding: 22px 30px 16px; max-width: 100%; border: 1px solid rgb(216, 40, 33); color: rgb(0, 0, 0); font-size: 16px;">
                <?= $content ?>
            </section>
        </section>
    </section>
<?php elseif ($style == 23): ?>

    <section
        style="font-size: 16px; line-height: 25.6px; margin: 20px 0; padding: 0px; color: rgb(0, 0, 0); font-family: 'Helvetica Neue', Helvetica, 'Hiragino Sans GB', 'Microsoft YaHei', Arial, sans-serif; text-align: center; vertical-align: middle;">
        <section class="wxqq-borderTopColor wxqq-borderBottomColor"
                 style="margin: 0px 1em; padding: 0px; font-size: 1em; border-width: 1.5em; border-style: solid; border-color: rgb(222, 84, 84) transparent; height: 0px;">
            <br style="margin: 0px; padding: 0px;"></section>
        <section
            style="margin: -2.75em 1.65em; padding: 0px; font-size: 1em; border-width: 1.3em; border-style: solid; border-color: rgb(255, 255, 255) transparent; height: 0px;"></section>
        <section class="wxqq-borderTopColor wxqq-borderBottomColor"
                 style="margin: 0.45em 2.1em; padding: 0px; border-width: 1.1em; border-style: solid; border-color: rgb(222, 84, 84) transparent; height: 0px; vertical-align: middle;">
            <section
                style="margin: -0.5em 0px 0px; padding: 0px 1em; color: white; line-height: 1em; overflow: hidden; max-height: 1em;">
                <?= $title ?>
            </section>
        </section>
    </section>

<?php elseif ($style == 24): ?>

    <section
        style="font-size: 1em; line-height: 25.6px; margin-top: 50px; padding: 0px; color: rgb(0, 0, 0); font-family: 'Helvetica Neue', Helvetica, 'Hiragino Sans GB', 'Microsoft YaHei', Arial, sans-serif; text-align: center; vertical-align: middle;">
        <section
            style="margin: -2.75em 1.65em; padding: 0px; border-width: 1.3em; border-style: solid; border-color: rgb(255, 255, 255) transparent; height: 0px;"></section>
        <section class="wxqq-borderTopColor wxqq-borderBottomColor"
                 style="margin: 0.45em 2.1em; padding: 0px; border-width: 1.1em; border-style: solid; border-color: rgb(222, 84, 84) transparent; height: 0px; vertical-align: middle;">
            <section
                style="margin: -0.5em 0px 0px; padding: 0px 1em; color: white; line-height: 1em; overflow: hidden; font-size: 1.2em; max-height: 1em;">
                <?= $title ?>
            </section>
        </section>
    </section>

<?php elseif ($style == 25): ?>

    <section label="Copyright Reserved by PLAYHUDONG."
             style="font-size: 16px; line-height: 25.6px; margin: 1em auto; padding: 0px; color: rgb(0, 0, 0); font-family: 'Helvetica Neue', Helvetica, 'Hiragino Sans GB', 'Microsoft YaHei', Arial, sans-serif; max-width: 100%; border-style: none; width: 290px; clear: both; text-align: center; overflow: hidden; word-wrap: break-word !important;">
        <span
            style="margin: 0px 6px 0px 0px; padding: 10px 8px; max-width: 100%; display: inline-block; vertical-align: bottom; border-top-style: solid; border-top-width: 1px; border-top-color: rgb(94, 107, 124); border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: rgb(94, 107, 124); width: 10em; line-height: 1.5; font-size: 14px; color: rgb(104, 104, 104); word-wrap: break-word !important;"><span
                class="color"
                style="margin: 0px; padding: 0px; max-width: 100%; word-wrap: break-word !important;">☂</span>
            <section
                style="margin: 0px; padding: 0px; max-width: 100%; word-wrap: break-word !important;">
                <?= $title ?>
            </section></span></section>
<?php elseif ($style == 26): ?>
    <section class="135editor" data-id="53787"
             style="color: rgb(0, 0, 0); font-size: 16px; font-family: 微软雅黑; margin: 0px; padding: 0px; border: 0px none; border-image-source: initial; border-image-slice: initial; border-image-width: initial; border-image-outset: initial; border-image-repeat: initial;">
        <section style="margin: 0.8em 25.2969px 0.3em; padding: 0px; border: none;">
            <section class="135brush" data-brushtype="text"
                     style="margin: 0px auto; padding: 9px 4px 14px; color: rgb(255, 100, 80); font-size: 20px; letter-spacing: 3px; text-align: center; border: 4px solid rgb(255, 100, 80); border-radius: 8px;">
                <?= $title ?>
            </section>
            <p style="margin-right: auto; margin-bottom: 0px; margin-left: auto; padding: 0px; clear: both; width: 0px; border-top-width: 0.6em; border-top-style: solid; border-bottom-color: rgb(255, 100, 80); border-top-color: rgb(255, 100, 80); height: 10px; border-left-width: 0.7em !important; border-left-style: solid !important; border-left-color: transparent !important; border-right-width: 0.7em !important; border-right-style: solid !important; border-right-color: transparent !important;">
                <br style="margin: 0px; padding: 0px;"></p></section>
        <section style="margin: 0px; padding: 0px; width: 0px; height: 0px; clear: both;"></section>
    </section>
    <?= $content ?>
<?php elseif ($style == 27): ?>


    <section class="135editor" data-id="53787"
             style="font-size: 16px; font-family: 微软雅黑; color: rgb(0, 0, 0); margin: 0px; padding: 0px; border: 0px none; border-image-source: initial; border-image-slice: initial; border-image-width: initial; border-image-outset: initial; border-image-repeat: initial;">
        <section style="margin: 0.8em 27.7969px 0.3em; padding: 0px; border: none;">
            <section class="135brush" data-brushtype="text"
                     style="margin: 0px auto; padding: 9px 4px 14px; color: rgb(55, 74, 174); font-size: 20px; letter-spacing: 3px; text-align: center; border: 4px solid rgb(55, 74, 174); border-radius: 8px;">
                <?= $title ?></section>
            <section
                style="margin: 0px auto; padding: 0px; width: 0px; border-top-width: 0.6em; border-top-style: solid; border-bottom-color: rgb(55, 74, 174); border-top-color: rgb(55, 74, 174); height: 10px; border-left-width: 0.7em !important; border-left-style: solid !important; border-left-color: transparent !important; border-right-width: 0.7em !important; border-right-style: solid !important; border-right-color: transparent !important;"></section>
        </section>
        <section style="margin: 0px; padding: 0px; width: 0px; height: 0px; clear: both;"></section>
    </section>
<?php elseif ($style == 28): ?>
    <section style="margin: 15px 0;">

        <?= $title ?>
    </section>
    <?php elseif ($style == 29): ?>
    <section style="margin: 15px 0; border-style: none none none solid; border-color: rgb(0, 0, 0); padding: 10px; line-height: 25px; color: rgb(153, 153, 153); box-shadow: rgb(153, 153, 153) 1px 1px 2px; border-left-width: 10px; background-color: rgb(243, 243, 243);">
        <?= $title ?>
    </section>
    <?php elseif ($style == 30): ?>
    <section style="margin: 15px 0; border-style: none none none solid; border-color:#e83f78; padding: 10px; line-height: 25px; color: rgb(153, 153, 153); box-shadow: rgb(153, 153, 153) 1px 1px 2px; border-left-width: 10px; background-color: rgb(243, 243, 243);">
        <?= $title ?>
    </section>
<?php endif; ?>
