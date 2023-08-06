<?php
declare(strict_types=1);
namespace BrokerBinance\Models;

class BinanceOrder
{
    public string $orderId;
    public string $symbol;
    public string $status;
    public string $clientOrderId;
    public string $price;
    public string $avgPrice;
    public string $origQty;
    public string $executedQty;
    public string $cumQuote;
    public string $timeInForce;
    public string $type;
    public string $reduceOnly;
    public string $closePosition;
    public string $side;
    public string $positionSide;
    public string $stopPrice;
    public string $workingType;
    public string $priceProtect;
    public string $origType;
    public string $time;
    public string $updateTime;
}