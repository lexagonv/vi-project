<?php

if (!function_exists('app')) {
    function app() {
        return \App\App::getInstance();
    }
}

if (!function_exists('config')) {
    function config($keyValue) {
        $config = app()->get('config');
        return $config->get($keyValue);
    }
}