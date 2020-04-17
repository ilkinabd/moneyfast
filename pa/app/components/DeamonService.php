<?php

namespace app\components;

use DateTime;
use Yii;
use yii2tech\filestorage\local\Storage;
use yii\base\BaseObject;
use yii\httpclient\Client;

class DeamonService extends BaseObject implements DeamonServiceInterface
{
    private $client;
    private $bucket;
    private $digitalSignService;
    public function __construct(Storage $storage, Client $client, DigitalSignServiceInterface $digitalSignService)
    {
        $this->digitalSignService = $digitalSignService;
        $this->bucket = $storage->getBucket('dataFiles');
        $this->client = $client;
    }

    public function handle()
    {
        $timeStamp = (new DateTime)->getTimestamp();
        $randomData = [
            'transaction_id' => $timeStamp . '',
            'sum' => rand(10, 500) . '',
            'comission' => (rand(5, 20) / 10) . '',
            'user_id' => rand(1, 20) . '',
        ];
        ksort($randomData);
        $rawData = json_encode($randomData);
        $this->bucket->saveFileContent($timeStamp . '.data', $rawData);

        $binary = $this->digitalSignService->sign($rawData);
        // echo $rawData;
        $signature = base64_encode($binary);
        $randomData['signature'] = $signature;

        // $ok = $this->digitalSignService->verify(json_encode($randomData), $signature);
        // echo $ok;
        $response = $this->client->createRequest()
            ->setMethod('POST')
            ->setUrl('http://192.168.0.5/transactions')
            ->setData($randomData)
            ->send();

        echo $response->content . PHP_EOL;

        if ($response->isOk) {
            echo 'HANDLE FINISH' . PHP_EOL;
        }
    }
}
