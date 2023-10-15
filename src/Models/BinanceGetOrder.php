<?php
declare(strict_types=1);
namespace BrokerBinance\Models;

class BinanceGetOrder
{
    public string $symbol;
    public string $orderId;
    public string $orderListId;
    public string $clientOrderId;
    public string $price;
    public string $origQty;
    public string $executedQty;
    public string $cummulativeQuoteQty;
    public string $status;
    public string $timeInForce;
    public string $type;
    public string $side;
    public string $stopPrice;
    public string $icebergQty;
    public string $time;
    public string $updateTime;
    public string $isWorking;
    public string $workingTime;
    public string $origQuoteOrderQty;
    public string $selfTradePreventionMode;
}