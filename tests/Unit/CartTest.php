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
        $cart = $this->createCart();

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
        $cart = $this->createCart();
        $cart->addProduct($product1);
        $cart->addProduct($product2);

        $cart->removeProduct(1);
        $actual = $cart->getProducts()->count();

        $expected = 1;
        $this->assertEquals($expected, $actual);
    }

    public function testGetTotalPriceWithNoProducts()
    {
        $cart = $this->createCart();

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
        $cart = $this->createCart();
        $cart->addProduct($product1);
        $cart->addProduct($product2);

        $actual = $cart->getTotalPrice();

        $expected = 35.07;
        $this->assertEquals($expected, $actual);
    }

    private function createProduct(
        int $id = null,
        string $title = null,
        float $price = null
    ) {

        $id = $id ? $id : rand(1, 50);
        $title = $title ? $title : 'someproduct';
        $price = $price ? $price : 10;

        return new Product($id, $title, $price);
    }

    private function createCart()
    {
        return new Cart();
    }
}
