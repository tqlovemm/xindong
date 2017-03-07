<?php
/*发顺丰*/
namespace yii\myhelper;

class BiHua
{
    private $data = array();
    public function find($str){

        $this->area();
        return array_search($str,$this->data);

    }
    public function total(){

        $this->area();
        return count($this->data);


    }

    private function area(){

        $this->domestic();
        $this->abroad();

    }

    private function domestic(){

        $this->data[6170] = "安徽";
        $this->data[580] = "北京";
        $this->data[490] = "天津";
        $this->data[960] = "重庆";
        $this->data[3100] = "上海";
        $this->data[850] = "河北";
        $this->data[360] = "山西";
        $this->data[450] = "辽宁";
        $this->data[680] = "吉林";
        $this->data[1256] = "黑龙江";
        $this->data[670] = "江苏";
        $this->data[1060] = "浙江";
        $this->data[1380] = "福建";
        $this->data[660] = "江西";
        $this->data[350] = "山东";
        $this->data[890] = "河南";
        $this->data[1251] = "湖北";
        $this->data[1290] = "湖南";
        $this->data[351] = "广东";
        $this->data[362] = "广西";
        $this->data[361] = "广州";
        $this->data[1160] = "深圳";
        $this->data[1530] = "澳门";
        $this->data[530] = "四川";
        $this->data[1090] = "海南";
        $this->data[961] = "贵州";
        $this->data[491] = "云南";
        $this->data[4135] = "内蒙古";
        $this->data[962] = "重庆";
        $this->data[9120] = "香港";
        $this->data[6171] = "西藏";
        $this->data[13190] = "新疆";
        $this->data[5120] = "台湾";
        $this->data[860] = "陕西";
        $this->data[8100] = "青海";
        $this->data[5100] = "宁夏";
        $this->data[581] = "甘肃";

    }
    private function abroad(){

        $this->data[1580] = "德国";
        $this->data[980] = "俄罗斯";
        $this->data[880] = "法国";
        $this->data[1190] = "菲律宾";
        $this->data[881] = "英国";
        $this->data[1337] = "意大利";
        $this->data[7120] = "阿联酋";
        $this->data[1590] = "澳洲";
        $this->data[451] = "日本";
        $this->data[1365] = "新西兰";
        $this->data[1358] = "新加坡";
        $this->data[6104] = "西班牙";
        $this->data[1080] = "泰国";
        $this->data[1330] = "瑞士";
        $this->data[376] = "马来西亚";
        $this->data[981] = "美国";
        $this->data[1050] = "荷兰";
        $this->data[1280] = "韩国";
        $this->data[5103] = "加拿大";
    }

}
