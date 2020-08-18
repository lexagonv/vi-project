<?php

define("BASEPATH", dirname(__DIR__));

$app = \App\App::getInstance(BASEPATH);
$config = new \App\Config\Config('config');
$config->addConfig('database.yaml');
$config->addConfig('app.yaml');

$app->add('config', $config);

if (config('system.orm')) {
    $orm = new \App\Orm\Orm(config('database'));
    $app->add('orm', $orm);
}

return $app;