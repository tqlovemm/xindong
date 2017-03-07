<?php
namespace backend\components;
use app\components\SaveToLog;
use backend\modules\bgadmin\models\AdminerActiveRecord;
use Yii;

class AddRecord
{

    public static function record($data){

        $model = new AdminerActiveRecord();
        $model->description = $data['description'];
        $model->data = $data['data'];
        $model->old_data = $data['old_data'];
        $model->new_data = $data['new_data'];
        $model->type = $data['type'];
        $model->save();

    }

}
