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
    public function __construct(Storage $storage, Client $client)
    {
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
            'order_number' => rand(1, 20)
        ];

        $this->bucket->saveFileContent($timeStamp . 'data', json_encode($randomData));

        $this->client->createRequest()
            ->setMethod('POST')
            ->setUrl('http://example.com/api/1.0/users')
            ->setData($randomData);

        echo 'handle' . PHP_EOL;
    }
}
