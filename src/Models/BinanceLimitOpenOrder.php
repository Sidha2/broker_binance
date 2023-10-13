<?php
declare(strict_types=1);
namespace BrokerBinance\Models;

class BinanceLimitOpenOrder
{
    public int $orderId;
    public string $symbol;
    public string $orderListId;
    public string $clientOrderId;
    public string $transactTime;
}