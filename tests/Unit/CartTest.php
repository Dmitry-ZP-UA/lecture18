<?php

namespace Tests\Unit;

use App\Models\Cart;
use App\Models\Product;
use Tests\TestCase;

class CartTest extends TestCase
{
    public function testAddProduct()
    {
        $product1 = $this->createProduct();
        $product2 = $this->createProduct();
        $cart = new Cart();

        $cart->addProduct($product1);
        $cart->addProduct($product2);
        $actual = $cart->getProducts()->count();

        $expected = 2;
        $this->assertEquals($expected, $actual);
    }

    public function testRemoveProduct()
    {
        $product1 = $this->createProduct(1);
        $product2 = $this->createProduct();
        $cart = new Cart();
        $cart->addProduct($product1);
        $cart->addProduct($product2);

        $cart->removeProduct(1);
        $actual = $cart->getProducts()->count();

        $expected = 1;
        $this->assertEquals($expected, $actual);
    }

    public function testGetTotalPriceWithNoProducts()
    {
        $cart = new Cart();

        $actual = $cart->getTotalPrice();

        $expected = 0;
        $this->assertEquals($expected, $actual);
    }

    public function testGetTotalPriceWithMultipleProducts()
    {
        $product1 = $this->createProduct();
        $product2 = $this->createProduct();
        $product1->setPrice(11.43);
        $product2->setPrice(23.64);
        $cart = new Cart();
        $cart->addProduct($product1);
        $cart->addProduct($product2);

        $actual = $cart->getTotalPrice();

        $expected = 35.07;
        $this->assertEquals($expected, $actual);
    }

    private function createProduct($id = null)
    {
        return $id
            ? new Product($id)
            : new Product(rand(1, 50));
    }
}
