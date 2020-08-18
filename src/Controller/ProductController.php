<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ProductController
 * @package App\Controller
 */
class ProductController extends Controller
{
    /**
     * Создание стартового набора данных
     * @return JsonResponse
     */
    public function generate()
    {
        $em = $this->getEntityManager();
        $count = 20;
        $repository = $em->getRepository('App\Entity\Products');
        $repository->generateStartList($count);

        return $this->response([
            'success' => true,
            'message' => 'Стартовый набор данных сгенерирован'
        ]);
    }
}