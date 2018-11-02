<?php

namespace App\Models;

use Illuminate\Support\Collection;

class Cart
{
    /**
     * @var Collection<Product>
     */
    private $products;

    public function __construct()
    {
        $this->products = new Collection();
    }

    /**
     * @return Collection
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product)
    {
        $this->products->push($product);
    }

    public function removeProduct(int $id)
    {
        $this->products = $this->products->reject(
            function (Product $product) use ($id) {
                return $product->getId() === $id;
            }
        );
    }

    public function getTotalPrice()
    {
        return $this->products->sum(function (Product $product) {
            return $product->getPrice();
        });
    }
}