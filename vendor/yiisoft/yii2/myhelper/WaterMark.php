<?php

namespace yii\myhelper;

class WaterMark
{

    public function imgMark($ground,$path,$waterImg='http://13loveme.com/images/watermark/13.png'){

        $groundImg = $ground;
        $groundInfo = getimagesize($groundImg);
        $ground_w = $groundInfo[0];
        $ground_h = $groundInfo[1];

        $type1 = image_type_to_extension($groundInfo[2],false);
        $fun1 = "imagecreatefrom{$type1}";
        $ground_im = $fun1($groundImg);

        $imgInfo =getimagesize($waterImg);
        $water_w = $imgInfo[0];
        $water_h = $imgInfo[1];

        $type2 = image_type_to_extension($imgInfo[2],false);
        $fun2 = "imagecreatefrom{$type2}";
        $water_im = $fun2($waterImg);

        imagecopy($ground_im,$water_im,($ground_w/2)-($water_w/2),($ground_h/2)-($water_h/2),0,0,$water_w,$water_h);

        /*销毁水印图片*/
        imagedestroy($water_im);

        header("Content-type:image/jpeg");
        $fun = "image{$type1}";
        $fun($ground_im,$path);
        imagedestroy($ground_im);

    }

    function wordMark(){

        $dst_path = '4006876523_289a8296ee.jpg';
        //创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        //打上文字
        $font = 'YGY20070701xinde52.ttf';//字体
        $black = imagecolorallocate($dst, 0x00, 0x00, 0x00);//字体颜色
        imagefttext($dst, 13, 0, 20, 140, $black, $font, '13loveme');
        imagefttext($dst, 13, 0, 20, 120, $black, $font, '十三平台');
        //输出图片
        list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
        switch ($dst_type) {
            case 1://GIF
                header('Content-Type: image/gif');
                imagegif($dst);
                break;
            case 2://JPG
                header('Content-Type: image/jpeg');
                imagejpeg($dst);
                break;
            case 3://PNG
                header('Content-Type: image/png');
                imagepng($dst);
                break;
            default:
                break;
        }
        imagedestroy($dst);

    }

}