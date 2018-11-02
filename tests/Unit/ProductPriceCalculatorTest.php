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

    /**
     * @param $saleInterval
     * @param $salePercent
     * @param $currentDatetime
     * @param $registerDatetime
     * @param $productPrices
     * @param $expected
     *
     * @dataProvider calculatorProvider
     */
    public function testProductsCalculator(
        $saleInterval,
        $salePercent,
        $currentDatetime,
        $registerDatetime,
        $productPrices,
        $expected
    ) {
        $config = [
            'sale_interval' => $saleInterval,
            'sale_percent' => $salePercent
        ];

        $calculator = $this->getCalculator(Carbon::parse($currentDatetime), $config);

        $user = new User();
        $user->setRegisterDatetime(Carbon::parse($registerDatetime));

        $products = $this->getProductsCollection($productPrices);

        $actual = $calculator->getTotalPrice($products, $user);

        $this->assertEquals($expected, $actual);
    }

    public function calculatorProvider()
    {
        return [
            // Аргументы к нашему тестовому методу
            [
                '2 day',      // <---- Сколько дней после регистрации
                //       пользователя действует скидка
                50,           // <---- Процент скидки, который мы указываем в конфиге
                '2018-10-27', // <---- Текущая дата
                '2018-10-26', // <---- Дата регистрации пользователя
                [15, 5],      // <---- Цена продуктов, которые купил пользователь
                10            // <---- Сумма покупки
            ],
            ['2 day', 50, '2018-10-30', '2018-10-26', [15, 5], 20],
            ['2 day', 50, '2018-10-30', '2018-10-26', [], 0]
        ];
    }
}
