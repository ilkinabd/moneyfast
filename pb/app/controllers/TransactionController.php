<?php

namespace app\controllers;

use app\components\DigitalSignServiceInterface;
use app\components\TransactionServiceInterface;
use app\models\Transaction;
use Yii;
use yii\rest\Controller;

class TransactionController extends Controller
{
    private $transactionService;
    private $digitalSignService;
    public function __construct(
        $id,
        $module,
        TransactionServiceInterface $transactionService,
        DigitalSignServiceInterface $digitalSignService,
        $config = []
    ) {
        $this->digitalSignService = $digitalSignService;
        $this->transactionService = $transactionService;
        parent::__construct($id, $module, $config);
    }

    public function actionCreate()
    {
        $transactionModel = new Transaction();
        $inputData = Yii::$app->request->post();
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
        return $this->transactionService->create($transactionModel);
    }
}
