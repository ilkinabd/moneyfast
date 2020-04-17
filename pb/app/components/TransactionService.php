<?php

namespace app\components;

use app\models\Transaction;
use yii\base\BaseObject;

class TransactionService extends BaseObject implements TransactionServiceInterface
{
    private $digitalSignService;

    public function __construct(DigitalSignServiceInterface $digitalSignService, $config = [])
    {
        $this->digitalSignService = $digitalSignService;
        parent::__construct($config);
    }

    public function create(Transaction $transactionModel)
    {
       return $transactionModel;
    }
}
