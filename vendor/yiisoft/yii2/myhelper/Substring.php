<?php
/**
 * Created by PhpStorm.
 * User: tqmm
 * Date: 15-11-23
 * Time: 下午8:56
 */

namespace yii\myhelper;

class Substring
{

    public $str;
    public $start_str;
    public $end_str;
    public $start_pos;
    public $end_pos;
    public $c_str_l;
    public $contents;
    function get_str($str,$start_str,$end_str){
        $this->str = $str;
        $this->start_str = $start_str;
        $this->end_str = $end_str;
        $this->start_pos = strpos($this->str,$this->start_str)+strlen($this->start_str);
        $this->end_pos = strpos($this->str,$this->end_str);
        $this->c_str_l = $this->end_pos - $this->start_pos;
        $this->contents = substr($this->str,$this->start_pos,$this->c_str_l);
        return $this->contents;
    }

}