<?php

namespace frontend\components;

use Yii;
use yii\myhelper\WaterMark;
use yii\myhelper\Thumb;

class UploadThumbAndWatermark
{
    private $fileField;            //文件域名
    private $file;                 //文件上传对象
    private $config;               //配置信息
    private $prefix;               //上传文件的名称前缀
    private $oriName;              //原始文件名
    private $fileName;             //新文件名
    private $fullName;             //完整文件名,即从当前配置目录开始的URL
    private $waterMark;             //水印文件路径
    private $addWaterMark;          //是否加水印
    private $thumb;                //是否略图
    private $fileSize;             //文件大小
    private $fileType;             //文件类型
    private $stateInfo;            //上传状态信息,
    private $stateMap = array(    //上传状态映射表，国际化用户需考虑此处数据的国际化
        "SUCCESS" ,                //上传成功标记，在UEditor中内不可改变，否则flash判断会出错
        "文件大小超出 upload_max_filesize 限制" ,
        "文件大小超出 MAX_FILE_SIZE 限制" ,
        "文件未被完整上传" ,
        "没有文件被上传" ,
        "上传文件为空" ,
        "POST" => "文件大小超出 post_max_size 限制" ,
        "SIZE" => "文件大小超出网站限制" ,
        "TYPE" => "不允许的文件类型" ,
        "DIR" => "目录创建失败" ,
        "IO" => "输入输出错误" ,
        "UNKNOWN" => "未知错误" ,
        "MOVE" => "文件保存时出错",
        "DIR_ERROR" => "创建目录失败"
    );
    /**
     * 构造函数
     * @param string $fileField 表单名称
     * @param array $config  配置项
     * @param string $prefix 上传文件的名称前缀
     * @param bool $base64  是否解析base64编码，可省略。若开启，则$fileField代表的是base64编码的字符串表单名
     */
    public function __construct( $fileField , $config , $prefix = '', $thumb = false,$addWaterMark = false,$base64 = false)
    {
        $this->fileField = $fileField;
        $this->thumb = $thumb;
        $this->addWaterMark = $addWaterMark;
        $this->config = $config;
        $this->prefix = $prefix;
        $this->stateInfo = $this->stateMap[ 0 ];
        $this->upFile( $base64 );
    }
    /**
     * 上传文件的主处理方法
     * @param $base64
     * @return mixed
     */
    private function upFile( $base64 )
    {

        $water = new WaterMark();
        //处理base64上传
        if ( "base64" == $base64 ) {
            $content = $_POST[ $this->fileField ];
            $this->base64ToImage( $content );
            return;
        }
        //处理普通上传
        $file = $this->file = $_FILES[ $this->fileField ];
        if ( !$file ) {
            $this->stateInfo = $this->getStateInfo( 'POST' );
            return;
        }
        if ( $this->file[ 'error' ] ) {
            $this->stateInfo = $this->getStateInfo( $file[ 'error' ] );
            return;
        }
        if ( !is_uploaded_file( $file[ 'tmp_name' ] ) ) {
            $this->stateInfo = $this->getStateInfo( "UNKNOWN" );
            return;
        }
        $this->oriName = $file[ 'name' ];
        $this->fileSize = $file[ 'size' ];
        $this->fileType = $this->getFileExt();
        if ( !$this->checkSize() ) {
            $this->stateInfo = $this->getStateInfo( "SIZE" );
            return;
        }
        if ( !$this->checkType() ) {
            $this->stateInfo = $this->getStateInfo( "TYPE" );
            return;
        }
        $folder = $this->getFolder();
        if ( $folder === false ) {
            $this->stateInfo = $this->getStateInfo( "DIR_ERROR" );
            return;
        }
        $name = $this->getName();
        $this->fullName = $folder . '/' . $name;

        if ( $this->stateInfo == $this->stateMap[ 0 ] ) {
            if ( !move_uploaded_file( $file[ "tmp_name" ] , $this->fullName ) ) {
                $this->stateInfo = $this->getStateInfo( "MOVE" );
            }
        }

        if($this->addWaterMark){
            $this->waterMark =  $folder . '/watermark/' . $this->getName();
            $water->imgMark($this->fullName,$this->waterMark,'http://13loveme.com/images/watermark/3333.png');
        }

        if($this->thumb){

            $this->thumb($this->fullName);
        }

    }

    /**
     * @param $im
     * @param $maxwidth
     * @param $maxheight
     * @param $name
     * @param $filetype
     * 压缩图片函数
     */

    private function thumb($im){

        $extension = pathinfo($im)["extension"];
        $filename = pathinfo($im)["filename"];
        $dir = pathinfo($im)['dirname'];
        $info = filesize($im) / 1024 / 1024;
        if ($info > 0.2) {
            if (in_array($extension, ['png'])) {
                $im = imagecreatefrompng($im);
            } elseif (in_array($extension, ['jpg'
                , 'jpeg'])) {
                $im = imagecreatefromjpeg($im);//参数是图片的存方路径
            } else {
                $im = imagecreatefromgif($im);//参数是图片的存方路径
            }
            $maxwidth = "1280";//设置图片的最大宽度
            $maxheight = "1280";//设置图片的最大高度
            $name = "$dir/thumb/$filename";//图片的名称，随便取吧
            $filetype = ".$extension";//图片类型
            $this->resizeImage($im, $maxwidth, $maxheight, $name, $filetype);//调用上面的函数
        }else{
            copy($im,"$dir/thumb/$filename.".$extension);
        }
    }
    private function resizeImage($im,$maxwidth,$maxheight,$name,$filetype){
        $pic_width = imagesx($im);
        $pic_height = imagesy($im);
        $widthratio = $heightratio = $resizeheight_tag = $resizewidth_tag = $ratio = false;

        if(($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight)) {
            if($maxwidth && $pic_width>$maxwidth) {
                $widthratio = $maxwidth/$pic_width;
                $resizewidth_tag = true;
            }

            if($maxheight && $pic_height>$maxheight) {
                $heightratio = $maxheight/$pic_height;
                $resizeheight_tag = true;
            }

            if($resizewidth_tag && $resizeheight_tag) {
                if($widthratio<$heightratio)
                    $ratio = $widthratio;
                else
                    $ratio = $heightratio;
            }

            if($resizewidth_tag && !$resizeheight_tag)
                $ratio = $widthratio;
            if($resizeheight_tag && !$resizewidth_tag)
                $ratio = $heightratio;

            $newwidth = $pic_width * $ratio;
            $newheight = $pic_height * $ratio;

            if(function_exists("imagecopyresampled")) {
                $newim = imagecreatetruecolor($newwidth,$newheight);//PHP系统函数
                imagecopyresampled($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);//PHP系统函数
            }
            else {
                $newim = imagecreate($newwidth,$newheight);
                imagecopyresized($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
            }
            $name = $name.$filetype;
            imagejpeg($newim,$name);
            imagedestroy($newim);
        } else {
            $name = $name.$filetype;
            imagejpeg($im,$name);
        }
    }
    /**
     * 处理base64编码的图片上传
     * @param $base64Data
     * @return mixed
     */

    private function base64ToImage( $base64Data )
    {
        $img = base64_decode( $base64Data );
        $this->fileName = time() . rand( 1 , 10000 ) . ".png";
        $this->fullName = $this->getFolder() . '/' . $this->fileName;
        if ( !file_put_contents( $this->fullName , $img ) ) {
            $this->stateInfo = $this->getStateInfo( "IO" );
            return;
        }
        $this->oriName = "";
        $this->fileSize = strlen( $img );
        $this->fileType = ".png";
    }
    /**
     * 获取当前上传成功文件的各项信息
     * @return array
     */
    public function getFileInfo( $addFlag=1 )
    {

        if($addFlag==1){

            $arr = explode('.',$this->oriName);
        }else{

            preg_match('/\d+/',$this->oriName,$arr);
        }

        return array(

            "originalName" => $arr[0],
            'original'=>$this->file['name'],
            "name" => $this->fileName ,
            "url" => $this->fullName ,
            "size" => $this->fileSize ,
            "type" => $this->fileType ,
            "state" => $this->stateInfo
        );
    }
    /**
     * 上传错误检查
     * @param $errCode
     * @return string
     */
    private function getStateInfo( $errCode )
    {
        return !$this->stateMap[ $errCode ] ? $this->stateMap[ "UNKNOWN" ] : $this->stateMap[ $errCode ];
    }
    /**
     * 重命名文件
     * @return string
     */
    private function getName()
    {
        //源文件名上传
        //return $this->fileName = $this->file['name'];
        //改变文件名上传
        return $this->fileName = $this->prefix . '_' . time() . rand( 1 , 10000 ) . $this->getFileExt();
    }
    /**
     * 文件类型检测
     * @return bool
     */
    private function checkType()
    {
        return in_array( $this->getFileExt() , $this->config[ "allowFiles" ] );
    }
    /**
     * 文件大小检测
     * @return bool
     */
    private function  checkSize()
    {
        return $this->fileSize <= ( $this->config[ "maxSize" ] * 1024 );
    }
    /**
     * 获取文件扩展名
     * @return string
     */
    private function getFileExt()
    {
        return strtolower( strrchr( $this->file[ "name" ] , '.' ) );
    }
    /**
     * 按照用户名自动创建存储文件夹
     * @return string
     */
    private function getFolder()
    {
        $pathStr = $this->config[ "savePath" ];
       /* if ( strrchr( $pathStr , "/" ) != "/" ) {
            $pathStr .= "/";
        }*/
       /* $pathStr .= Yii::$app->user->id;

        if ( !file_exists( $pathStr ) ) {
            if ( !mkdir( $pathStr , 0777 , true ) ) {
                return false;
            }
        }*/
        return $pathStr;
    }
    /**
     * 按照日期自动创建存储文件夹
     * @return string
     */
    // private function getFolder()
    // {
    //     $pathStr = $this->config[ "savePath" ];
    //     if ( strrchr( $pathStr , "/" ) != "/" ) {
    //         $pathStr .= "/";
    //     }
    //     $pathStr .= date( "Ymd" );
    //     if ( !file_exists( $pathStr ) ) {
    //         if ( !mkdir( $pathStr , 0777 , true ) ) {
    //             return false;
    //         }
    //     }
    //     return $pathStr;
    // }
}
