<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 02.11.18
 * Time: 16:20
 */

namespace App\Services\Ecommerce;

use App\Models\Product;
use App\Models\User;
use App\Services\System\TimeManager;
use Illuminate\Support\Collection;

class ProductPriceCalculator
{
    /**
     * @var \DateInterval
     */
    private $saleInterval;

    /**
     * @var int
     */
    private $salePercent;

    /**
     * @var TimeManager
     */
    private $timeManager;

    public function __construct(TimeManager $timeManager, $config)
    {
        $this->saleInterval = \DateInterval::createFromDateString($config['sale_interval']);
        $this->salePercent = $config['sale_percent'];
        $this->timeManager = $timeManager;
    }

    public function getTotalPrice(Collection $products, User $user): float
    {
        // Время регистрации
        $registrationDatetime = $user->getRegisterDatetime();
        // Текущее время
        $currentDatetime = $this->timeManager->getTime();

        // Получаем разницу в днях
        $daysDiff = $currentDatetime->diff($registrationDatetime)->d;

        // Считаем суммарную стоимость продуктов
        $productsPrice = $products->sum(function (Product $product) {
            return $product->getPrice();
        });

        // Если разница в днях меньше или равно интервалу, который мы указали в конфиге
        if ($daysDiff <= $this->saleInterval->d) {

            return $productsPrice - (float)bcmul(
                    $productsPrice,
                    (float) bcdiv(
                        $this->salePercent,
                        100,
                        2
                    ),
                    2
                );
        } else {
            // Иначе возвращаем суммарную стоимость продуктов
            return $productsPrice;
        }
    }
}
