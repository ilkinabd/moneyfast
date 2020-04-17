<?php

namespace app\models;

use yii\db\ActiveRecord;

class Transaction extends ActiveRecord
{
    public $comission;
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
            // атрибут required указывает, что name, email, subject, body обязательны для заполнения
            [['transaction_id', 'sum', 'user_id', 'comission'], 'required'],

            [['transaction_id', 'user_id'], 'integer'],

            [['sum', 'comission'], 'double']
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['sum'] = function (Transaction $model) {
            return $model->sum - ($model->sum * $model->comission / 100);
        };
        return $fields;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $userWallet = new UserWallet();
            $userWallet->user_id = $this->user_id;
            $userWallet->sum = $this->sum;
            $userWallet->save();
        }
    }
}
