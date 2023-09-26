<?php
declare(strict_types=1);
namespace BrokerBinance\Models;

use BrokerBinance\Enums\BuySellType;
use BrokerBinance\Enums\OrderType;
use BrokerBinance\Enums\PositionSide;

class Order
{
    public int $orderId;
    public string $symbol;
    public string $avgPrice;
    public string $origQty;
    public string $executedQty;
    public string $cumQuote;
    public OrderType $orderType;
    public PositionSide $positionSide;
    public BuySellType $openCloseType;
    public string $targetPrice;
    public string $time;
    public string $updateTime;
}