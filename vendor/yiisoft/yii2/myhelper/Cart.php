<?php

namespace yii\myhelper;

class Cart
{
    static protected $ins;
    protected $item = array();//放商品
    final protected function _construct(){}
    final protected function __clone(){}

    static protected function Getins()
    {
        if (!(self::$ins instanceof self)) {

            self::$ins = new self();
        }
        return self::$ins;
    }


    public static function Getcat()
    {

        if (!($_SESSION['cat']) || !($_SESSION['cat'] instanceof self)) {

            $_SESSION['cat'] = self::Getins();
        }
        return $_SESSION['cat'];
    }

    public function Initem($goods_id)
    {
        if ($this->Gettype() == 0) {

            return false;

        }
        if(!(array_key_exists($goods_id,$this->item))){

            return false;

        }else{

            return $this->item[$goods_id]['num'];
        }
    }

    //添加商品
    public function Additem($goods_id,$name,$num,$price)
    {

        if ($this->Initem($goods_id) !== false) {
            $this->item[$goods_id]['num'] += $num;
            return;
        }
        $this->item[$goods_id]['id']= $goods_id;
        $this->item[$goods_id]['num'] = $num;
        $this->item[$goods_id]['name'] = $name;
        $this->item[$goods_id]['price'] = $price;
    }
    //减少商品
    public function Reduceitem($goods_id, $num)
    {

        if ($this->Initem($goods_id) == false) {
            return;
        }
        if ($num > $this->Getunm($goods_id)) {
            unset($this->item[$goods_id]);
        } else {
            $this->item[$goods_id]['num'] -= $num;
        }
    }

    //删除商品
    public function Delitem($goods_id)
    {
        if ($this->Initem($goods_id)) {
            unset($this->item[$goods_id]);
        }

    }

    public function Itemlist()
    {
        return $this->item;
    }

    public function Gettype()
    {
        return count($this->item);
    }

    public function Getunm($goods_id)
    {
        return $this->item[$goods_id];
    }
    //商品数量
    public function Getnumber()
    {

        $num = 0;
        if ($this->Gettype() == 0) {
            return 0;
        }
        foreach ($this->item as $k => $v) {
            $num += $v['num'];
        }
        return $num;
    }
    //总价格
    public function Getprice()
    {

        $price = 0;
        if ($this->Gettype() == 0) {

            return 0;
        }
        foreach ($this->item as $k => $v) {
            $price += $v['num'] * $v['price'];
        }
        return $price;
    }
    //清空购物车
    public function Emptyitem()
    {

        $this->item = array();
    }


}