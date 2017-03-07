<?php

namespace app\components;

class SaveToLog
{
    /**
     * @param $data
     * @param string $file
     */
    public static function log($data,$file='error.log'){

        $open=fopen($file,"a" );
        fwrite($open,json_encode($data));
        fclose($open);
    }

}