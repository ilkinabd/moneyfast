<?php

namespace app\commands;

use app\components\DeamonServiceInterface;
use yii\console\Controller;

class DeamonController extends Controller
{
    public $message;

    protected $deamonService;

    public function __construct($id, $module, DeamonServiceInterface $deamonService, $config = [])
    {
        $this->deamonService = $deamonService;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        echo 'STARTING DEAMON' . PHP_EOL;
        while (true) {
            $this->deamonService->handle();
            sleep(20);
        }
    }
}
