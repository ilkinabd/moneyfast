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
        $inputData = Yii::$app->request->post();
        return $this->transactionService->create($inputData);
    }

    public function actionIndex()
    {
        return $this->transactionService->list();
    }
}
