<?php
declare(strict_types=1);
namespace BrokerBinance\Models;

use BrokerBinance\Enums\BuySellType;
use BrokerBinance\Enums\PositionSide;

class BinanceLimitOrder
{
    public int $orderId;
    public string $symbol;
    public string $orderListId;
    public string $clientOrderId;
    public string $transactTime;
}