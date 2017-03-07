<?php

namespace yii\myhelper;

class Random
{

    public static function get_random_code ($length = 32, $mode = 0)
    {
        switch ($mode) {
            case "1":
                $str = "1234567890";
                break;
            case "2":
                $str = "abcdefghijklmnopqrstuvwxyz";
                break;
            case "3":
                $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                break;
            case "4":
                $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
                break;
            case "5":
                $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
                break;
            case "6":
                $str = "abcdefghijklmnpqrstuvwxyz234567890";
                break;
            default:
                $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
                break;
        }
        $result="";
        $l=strlen($str);
        for($i=0;$i < $length;$i++){
            $num = rand(0, $l-1); //���$i����1,����һ������4λ��, ��Ϊ$num = rand(0,10).���������10,$str[10] Ϊ��
            $result .= $str[$num];
        }
        return $result;
    }
}