<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class Counter extends ActiveRecord
{
    const HOUR_SECOND =3600;
    const DAY_SECOND =86400;

    public $created_at;
    public $today;
    public $hour;
    public static function tableName(){

        return '{{%admin_counter}}';

    }

    public function rules(){

        return "[
z

            [['created_at','today','hour'],'integer'],
            [['created_at','today','hour'],'required'],

        ]";


    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_by' => Yii::t('app','Created By'),
            'today' => Yii::t('app','Today'),
            'hour' => Yii::t('app','Hour'),

        ];
    }


    public function Create(){

        Yii::$app->db->createCommand()->insert('{{%admin_counter}}', [
            'created_at' => time(),
            'today' => strtotime('today'),
            'hour'=>$this->Range(),
        ])->execute();

    }


    public function Sum(){

        return Yii::$app->db
            ->createCommand("SELECT count(*) FROM {{%admin_counter}}")
            ->queryScalar();

    }

    /**
     * $num��ȥ�ڼ���ķ�����
     */
    public function Previously($num){

          return Yii::$app->db
              ->createCommand("SELECT count(*) FROM {{%admin_counter}} WHERE today=".(strtotime('today')-($num*self::DAY_SECOND)))
              ->queryScalar();

    }

    public function Range(){

        if(time()>=strtotime('today')&&time()<(strtotime('today')+self::HOUR_SECOND)){

            return 1;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND)&&time()<(strtotime('today')+self::HOUR_SECOND*2)){

            return 2;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*2)&&time()<(strtotime('today')+self::HOUR_SECOND*3)){

            return 3;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*3)&&time()<(strtotime('today')+self::HOUR_SECOND*4)){

            return 4;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*4)&&time()<(strtotime('today')+self::HOUR_SECOND*5)){

            return 5;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*5)&&time()<(strtotime('today')+self::HOUR_SECOND*6)){

            return 6;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*6)&&time()<(strtotime('today')+self::HOUR_SECOND*7)){

            return 7;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*7)&&time()<(strtotime('today')+self::HOUR_SECOND*8)){

            return 8;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*8)&&time()<(strtotime('today')+self::HOUR_SECOND*9)){

            return 9;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*9)&&time()<(strtotime('today')+self::HOUR_SECOND*10)){

            return 10;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*10)&&time()<(strtotime('today')+self::HOUR_SECOND*11)){

            return 11;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*11)&&time()<(strtotime('today')+self::HOUR_SECOND*12)){

            return 12;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*12)&&time()<(strtotime('today')+self::HOUR_SECOND*13)){

            return 13;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*13)&&time()<(strtotime('today')+self::HOUR_SECOND*14)){

            return 14;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*14)&&time()<(strtotime('today')+self::HOUR_SECOND*15)){

            return 15;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*15)&&time()<(strtotime('today')+self::HOUR_SECOND*16)){

            return 16;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*16)&&time()<(strtotime('today')+self::HOUR_SECOND*17)){

            return 17;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*17)&&time()<(strtotime('today')+self::HOUR_SECOND*18)){

            return 18;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*18)&&time()<(strtotime('today')+self::HOUR_SECOND*19)){

            return 19;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*19)&&time()<(strtotime('today')+self::HOUR_SECOND*20)){

            return 20;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*20)&&time()<(strtotime('today')+self::HOUR_SECOND*21)){

            return 21;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*21)&&time()<(strtotime('today')+self::HOUR_SECOND*22)){

            return 22;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*22)&&time()<(strtotime('today')+self::HOUR_SECOND*23)){

            return 23;

        }elseif(time()>=(strtotime('today')+self::HOUR_SECOND*23)&&time()<(strtotime('today')+self::HOUR_SECOND*24)){

            return 24;

        }


    }

    public function Group(){

        return Yii::$app->db
            ->createCommand('SELECT count(*) as count,hour FROM pre_admin_counter where today='.strtotime("today").' GROUP BY hour ')
            ->queryAll();

    }


    public function Clear($days){

        return Yii::$app->db->createCommand('delete from pre_admin_counter where today<='.(strtotime('today')-($days*self::DAY_SECOND)))
            ->queryScalar();

    }

}