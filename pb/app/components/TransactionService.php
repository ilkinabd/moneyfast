<?php

namespace app\components;

use app\models\Transaction;
use app\models\UserWallet;
use yii\base\BaseObject;

class TransactionService extends BaseObject implements TransactionServiceInterface
{
    private $digitalSignService;

    public function __construct(DigitalSignServiceInterface $digitalSignService, $config = [])
    {
        $this->digitalSignService = $digitalSignService;
        parent::__construct($config);
    }

    public function create($inputData)
    {
        $transactionModel = new Transaction();
        $binary = base64_decode($inputData['signature']);
        unset($inputData['signature']);
        ksort($inputData);
        $rawData = json_encode($inputData);
        $ok = $this->digitalSignService->verify($rawData, $binary);
        if ($ok !== 1) {
            $transactionModel->addError('signature', 'Invalid signature');
            return $transactionModel;
        }
        $transactionModel->setAttributes($inputData);
        $transactionModel->save();

        $userId = $transactionModel->getAttribute('user_id');

        $userWallet = UserWallet::findOne([
            'user_id' => $userId
        ]);

        $rawSum = $transactionModel->sum - ($transactionModel->sum * $transactionModel->comission / 100);
        if (!$userWallet) {
            $uw = new UserWallet();
            $uw->user_id = $userId;
            $uw->sum = $rawSum;
            $uw->save();
            return ['user_wallet' => $uw, 'transaction' => $transactionModel];
        } else {
            $userWallet->sum += $rawSum;
            $userWallet->save();
            return ['user_wallet' => $userWallet, 'transaction' => $transactionModel];
        }
    }

    public function list()
    {
        return Transaction::find()->orderBy('id DESC')->all();
    }
}
