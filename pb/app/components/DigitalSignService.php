<?php

namespace app\components;

use Yii;
use yii\base\BaseObject;

class DigitalSignService extends BaseObject implements DigitalSignServiceInterface
{
    private $privateKey;
    private $publicKey;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function setPrivateKey($privateKey)
    {
        $realPath = Yii::getAlias($privateKey);
        if (file_exists($realPath)) {
            $this->privateKey = file_get_contents($realPath);
        }
    }

    public function setPublicKey($publicKey)
    {
        $realPath = Yii::getAlias($publicKey);
        if (file_exists($realPath)) {
            $this->publicKey = file_get_contents($realPath);
        }
    }

    public function verify($data, $signature)
    {
        return openssl_verify($data, $signature, $this->publicKey, OPENSSL_ALGO_SHA1);
    }

    public function sign($data)
    {
        $signature = '';
        openssl_sign($data, $signature, $this->privateKey, OPENSSL_ALGO_SHA1);
        return $signature;
    }
}
