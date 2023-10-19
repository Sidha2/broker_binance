<?php
declare(strict_types=1);
namespace BrokerBinance\Models;

use BrokerBinance\Enums\BuySellType;
use BrokerBinance\Enums\LimitOrderStatus;

class LimitOrder
{
    public int $orderId;
    public string $symbol;
    public string $price;
    public string $realizedPrice;
    public string $quantity;
    public string $time;
    public string $updateTime;
    public string $status;
    public string $clientOrderId;
    public string $positionSide;

    public function __construct()
    {
        $this->status = LimitOrderStatus::NEW ->name;
    }
}