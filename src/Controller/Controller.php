<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class Controller implements ControllerInterface
{
    public function response($data, $status = 200)
    {
        return new JsonResponse($data, $status);
    }

    public function getEntityManager(): EntityManager
    {
        return app()->get('orm')->getEntityManager();
    }
}