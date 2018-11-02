<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 02.11.18
 * Time: 16:23
 */

namespace Tests\Unit;

use App\Models\Product;
use App\Models\User;
use App\Services\Ecommerce\ProductPriceCalculator;
use App\Services\System\TimeManager;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ProductPriceCalculatorTest extends TestCase
{
    /**
     * @param Carbon $currentTime
     * @param $config
     *
     * @return ProductPriceCalculator
     */
    private function getCalculator(Carbon $currentTime, $config)
    {
        $timeManagerMock = $this->getMockBuilder(TimeManager::class)
            ->setMethods(['getTime'])
            ->getMock();

        $timeManagerMock
            ->method('getTime')
            ->willReturn($currentTime);

        return new ProductPriceCalculator($timeManagerMock, $config);
    }

    private function getProductsCollection(array $prices)
    {
        $productsArr = array_map(function ($price) {
            $product = new Product(0);
            $product->setPrice($price);

            return $product;
        }, $prices);

        return new Collection($productsArr);
    }


    public function testProductsWithSale()
    {
        $config = [
            'sale_interval' => '2 day',
            'sale_percent' => 50
        ];

        $calculator = $this->getCalculator(Carbon::parse('2018-10-27'), $config);

        $user = new User();
        $user->setRegisterDatetime(Carbon::parse('2018-10-26'));

        $products = $this->getProductsCollection([
            15, 5
        ]);

        $actual = $calculator->getTotalPrice($products, $user);
        $expected = 10;

        $this->assertEquals($expected, $actual);
    }

    public function testProductsWithoutSale()
    {
        $config = [
            'sale_interval' => '2 day',
            'sale_percent' => 50
        ];
        $calculator = $this->getCalculator(Carbon::parse('2018-10-30'), $config);
        $user = new User();
        $user->setRegisterDatetime(Carbon::parse('2018-10-26'));

        $products = $this->getProductsCollection([
            15, 5
        ]);

        $actual = $calculator->getTotalPrice($products, $user);
        $expected = 20;

        $this->assertEquals($expected, $actual);
    }
}
