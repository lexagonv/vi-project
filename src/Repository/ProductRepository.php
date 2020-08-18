<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ProductRepository extends EntityRepository
{
    /**
     * @param $count
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function generateStartList($count)
    {
        $productNumber = 1;
        while ($productNumber <= $count) {
            $product = new Products();
            $product
                ->setName('product_' . $productNumber)
                ->setPrice(rand(100, 10000));
            $this->_em->persist($product);
            $productNumber++;
        }
        $this->_em->flush();
    }

}


