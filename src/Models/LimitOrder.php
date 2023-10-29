<?php
declare(strict_types=1);
namespace BrokerBinance\Models;

use BrokerBinance\Enums\BuySellType;
use BrokerBinance\Enums\LimitOrderStatus;
use BrokerBinance\Enums\OrderType;

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
    public string $type;

    public function __construct()
    {
        $this->status = LimitOrderStatus::NEW ->name;
        $this->type = OrderType::LIMIT->name;
        $this->realizedPrice = "0";
        $this->updateTime = "0";
    }
}