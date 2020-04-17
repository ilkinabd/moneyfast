<?php

namespace app\controllers;

use app\models\Transaction;
use yii\rest\ActiveController;

class TransactionController extends ActiveController
{
    public $modelClass = Transaction::class;
}
