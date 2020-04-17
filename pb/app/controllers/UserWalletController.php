<?php

namespace app\controllers;

use app\models\UserWallet;
use yii\rest\ActiveController;

class UserWalletController extends ActiveController
{
    public $modelClass = UserWallet::class;
}
