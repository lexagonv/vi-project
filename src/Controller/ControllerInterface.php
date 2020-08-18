<?php

namespace App\Controller;

interface ControllerInterface
{
    public function response($data, $status = 200);
    public function getEntityManager();
}