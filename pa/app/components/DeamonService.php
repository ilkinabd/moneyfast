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
            'id' => $timeStamp,
            'sum' => rand(10, 500),
            'comission' => rand(5, 20) / 10,
            'order_number' => rand(1, 20),
            'signature' => ''
        ];

        $rawData = json_encode($randomData);
        $this->bucket->saveFileContent($timeStamp . '.data', $rawData);

        $binary = $this->digitalSignService->sign($rawData);
        $signature = base64_encode($binary);
        $randomData['signature'] = $signature;

        // $ok = $this->digitalSignService->verify(json_encode($randomData), $signature);
        // echo $ok;
        $response = $this->client->createRequest()
            ->setMethod('POST')
            ->setUrl('http://example.com/api/1.0/users')
            ->setData($randomData)
            ->send();

        if ($response->isOk) {
            echo 'HANDLE FINISH' . PHP_EOL;
        }
    }
}
