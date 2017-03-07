<?php

namespace common\components;

use frontend\modules\member\models\UserBgRecord;

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
    public static function log2($data,$file='error.log'){

        $open=fopen($file,"a" );
        fwrite($open,json_encode($data));
        fwrite($open,"\n");
        fclose($open);
    }


    public static function userBgRecord($data,$user_id = ''){

        $web_id = (\Yii::$app->user->isGuest)?'10000':\Yii::$app->user->id;
        $userId = !empty($user_id)?$user_id:$web_id;
        $model = new UserBgRecord();
        $model->description = $data;
        $model->user_id = $userId;
        $model->save();
    }

}