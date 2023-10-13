<?php
declare(strict_types=1);
namespace BrokerBinance\Models;

class BinanceLimitCloseOrder
{
    public string $symbol;
    public int $origClientOrderId;
    public int $orderId;
    public int $orderListId;
    public string $clientOrderId;
    public string $transactTime;
    public string $price;
    public string $origQty;
    public string $executedQty;
    public string $cummulativeQuoteQty;
    public string $status;
    public string $timeInForce;
    public string $type;
    public string $side;
    public string $selfTradePreventionMode;
}