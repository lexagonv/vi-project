<?php

namespace App\Repository;

use App\Entity\Orders;
use App\Entity\Products;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class OrderRepository extends EntityRepository
{
    /**
     * @param $products
     * @return Orders
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create($products): Orders
    {
        $productRepository = $this->_em->getRepository('App\Entity\Products');
        $order = new Orders();
        $order->setNumber(rand(100, 100000));
        $sum = 0;

        foreach ($products as $productId) {
            /** @var Products $product */
            $product = $productRepository->findOneBy(['id' => $productId]);
            $order->addProduct($product);
            $sum += $product->getPrice();
        }
        $order->setSum($sum);
        $this->_em->persist($order);
        $this->_em->flush();

        return $order;
    }

}


