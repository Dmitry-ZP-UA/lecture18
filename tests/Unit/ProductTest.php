<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 02.11.18
 * Time: 16:38
 */

namespace Tests\Unit;

use App\Models\Product;
use LogicException;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * @expectedException LogicException
     */
    public function testNegativePrice()
    {
        $price = -2;

        $product = new Product(0);
        $product->setPrice($price);
    }
}
