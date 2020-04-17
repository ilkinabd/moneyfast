<?php

namespace app\models;

use app\components\DigitalSignService;
use app\components\DigitalSignServiceInterface;
use Yii;
use yii\db\ActiveRecord;

class Transaction extends ActiveRecord
{
    /**
     * @return string название таблицы, сопоставленной с этим ActiveRecord-классом.
     */
    public static function tableName()
    {
        return '{{%transactions}}';
    }

    public function rules()
    {
        return [

            [['transaction_id', 'sum', 'user_id', 'comission'], 'required'],

            [['transaction_id', 'user_id'], 'integer'],
        ];
    }
    
}
