<?php

namespace app\models;

use yii\db\ActiveRecord;

class Userwallet extends ActiveRecord
{
    /**
     * @return string название таблицы, сопоставленной с этим ActiveRecord-классом.
     */
    public static function tableName()
    {
        return '{{%user_wallet}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'sum'], 'required'],

            ['user_id', 'integer'],

            ['sum', 'double']
        ];
    }
}
