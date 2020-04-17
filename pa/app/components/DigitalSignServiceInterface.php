<?php

namespace app\components;


interface DigitalSignServiceInterface
{
    public function sign($data);
    public function verify($data, $signature);
}
