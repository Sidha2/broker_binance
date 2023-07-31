<?php
declare(strict_types=1);
use BrokerBinance\Models\TradeType;

class BrokerSettings
{
    private string $pair;
    private TradeType $tradeType;

    public function __construct(string $pair, TradeType $tradeType)
    {
        $this->tradeType = $tradeType;
        $this->pair = $pair;
    }
}