<?php

namespace app\controllers;

use app\models\UserWallet;
use yii\rest\ActiveController;

class UserwalletController extends ActiveController
{
    public $modelClass = Userwallet::class;
}
