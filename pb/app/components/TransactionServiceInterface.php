<?php

namespace app\components;

use app\models\Transaction;

interface TransactionServiceInterface
{
    public function create(Transaction $transaction);
}
