<?php

namespace App\Config;

interface  ConfigInterface
{
    public function addConfig($file);
    public function get($keyValue);
}