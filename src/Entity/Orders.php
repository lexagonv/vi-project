<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="Orders")
 */
class Orders
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $number;
    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $sum = 0.0;
    /**
     * @ORM\Column(type="boolean")
     */
    private $isPaid = false;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Products")
     * @ORM\JoinTable(name="order_products",
     *      joinColumns={@ORM\JoinColumn(name="order_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")}
     *      )
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     * @return Orders
     */
    public function setNumber($number): Orders
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @param float $sum
     * @return Orders
     */
    public function setSum(float $sum): Orders
    {
        $this->sum = $sum;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPaid(): bool
    {
        return $this->isPaid;
    }

    /**
     * @param bool $isPaid
     * @return Orders
     */
    public function setIsPaid(bool $isPaid): Orders
    {
        $this->isPaid = $isPaid;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getProducts(): ArrayCollection
    {
        return $this->products;
    }

    /**
     * @param ArrayCollection $products
     * @return Orders
     */
    public function setProducts(ArrayCollection $products): Orders
    {
        $this->products = $products;
        return $this;
    }

    /**
     * @param Products $product
     * @return Orders
     */
    public function addProduct(Products $product): Orders
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
        }
        return $this;
    }

    /**
     * @param Products $product
     * @return Orders
     */
    public function deleteProduct(Products $product): Orders
    {
        if ($this->products->contains($product)) {
            $this->products->remove($product);
        }
        return $this;
    }
}
