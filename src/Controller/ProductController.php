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
        $request = app()->getRequest();
        $login = $request->headers->get('login');
        if (!$login or $login != 'admin') {
            return $this->response([
                'success' => false,
                'message' => 'Доступ закрыт',
            ]);
        }
        $request = app()->getRequest();
        if ($request->getMethod() != 'GET') {
            return $this->response([
                'success' => false,
                'message' => 'Принимаются только GET-запросы',
            ]);
        }
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