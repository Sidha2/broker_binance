<?php
declare(strict_types=1);
namespace BrokerBinance\Models;

use BrokerBinance\Enums\BuySellType;
use BrokerBinance\Enums\PositionSide;

class LimitOrder
{
    public int $orderId;
    public string $symbol;
    public string $price;
    public string $quantity;
    public BuySellType $openCloseType;
    public string $time;
    public string $updateTime;
}