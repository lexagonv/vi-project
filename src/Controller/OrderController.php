<?php

namespace App\Controller;

use App\Entity\Orders;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class OrderController
 * @package App\Controller
 */
class OrderController extends Controller
{
    /**
     * Создание нового заказа
     * @return JsonResponse
     */
    public function create()
    {
        $request = app()->getRequest();
        $login = $request->headers->get('login');
        if (!$login or $login != 'admin') {
            return $this->response([
                'success' => false,
                'message' => 'Доступ закрыт',
            ]);
        }
        if ($request->getMethod() != 'POST') {
            return $this->response([
                'success' => false,
                'message' => 'Принимаются только POST-запросы',
            ]);
        }
        $em = $this->getEntityManager();
        $repository = $em->getRepository('App\Entity\Orders');
        $products = json_decode($request->request->get('products'), true);
        if (empty($products)) {
            return $this->response([
                'success' => false,
                'message' => 'Не указаны товары для заказа'
            ]);
        }
        /** @var Orders $order */
        $order = $repository->create($products);

        return $this->response([
            'success' => true,
            'message' => 'Заказ успешно создан',
            'orderId' => $order->getId(),
            'orderNumber' => $order->getNumber(),
            'orderSum' => $order->getSum()
        ]);
    }

    /**
     * Оплата заказа
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function pay()
    {
        $request = app()->getRequest();
        $login = $request->headers->get('login');
        if (!$login or $login != 'admin') {
            return $this->response([
                'success' => false,
                'message' => 'Доступ закрыт',
            ]);
        }
        if ($request->getMethod() != 'POST') {
            return $this->response([
                'success' => false,
                'message' => 'Принимаются только POST-запросы',
            ]);
        }
        $em = $this->getEntityManager();
        $orderData = json_decode($request->request->get('order'), true);
        $id = isset($orderData['id']) ? $orderData['id'] : null;
        if (!$id) {
            return $this->response([
                'success' => false,
                'message' => 'Не указан заказ для оплаты',
            ]);
        }

        /** @var Orders $order */
        $order = $em->getRepository('App\Entity\Orders')->findOneBy(['id' => $id]);
        if (!$order) {
            return $this->response([
                'success' => false,
                'message' => 'Заказ не найден',
            ]);
        }

        if ($order->isPaid()) {
            return $this->response([
                'success' => false,
                'message' => 'Заказ уже оплачен',
            ]);
        }

        $sum = isset($orderData['sum']) ? $orderData['sum'] : null;
        if ($order->getSum() != $sum) {
            return $this->response([
                'success' => false,
                'message' => 'Сумма для оплаты указана неверно',
            ]);
        }

        $ch = curl_init('https://ya.ru');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpcode == 200) {
            $order->setIsPaid(true);
            $em->persist($order);
            $em->flush();

            return $this->response([
                'success' => true,
                'message' => 'Оплата принята'
            ]);
        }
        return $this->response([
            'success' => false,
            'message' => 'Оплата не принята',
        ]);
    }
}