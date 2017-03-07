<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/8
 * Time: 11:28
 */
namespace api\modules\v5\models;
use app\components\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "pre_recharge_record".
 *
 * @property integer $user_id
 * @property integer $order_number
 * @property integer $alipay_order
 * @property integer $giveaway
 * @property integer $number
 * @property integer $week_time
 * @property integer $subject
 * @property integer $mouth_time
 * @property string $type
 * @property string $extra
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $platform
 */

class Webhook extends ActiveRecord
{

}