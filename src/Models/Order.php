<?php
declare(strict_types=1);
namespace BrokerBinance\Models;

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
    public OpenCloseType $openCloseType;
    public string $targetPrice;
    public string $time;
    public string $updateTime;

    public function __construct()
    {
    }
}