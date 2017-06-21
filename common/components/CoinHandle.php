<?php

namespace common\components;

use common\models\CoinConsumptionDetails;
use frontend\models\UserData;

class CoinHandle
{

    public function adjustment($user_id,$coin,$type,$extra=null){

        if($coin>0){

            $model = new CoinConsumptionDetails();
            $user = UserData::findOne($user_id);

            $model->user_id = $user_id;
            $model->coin = $coin;
            $model->transaction = date('Y').date('m').date('d').time().uniqid();
            $model->type = $type;
            $model->extra = $extra;
            $model->balance = $user->jiecao_coin;

            if($model->save()){
                return $model;
            }else{
                return $model->errors;
            }
        }

    }

}
