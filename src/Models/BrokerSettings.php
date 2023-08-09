<?php
declare(strict_types=1);

namespace BrokerBinance\Models;

use BrokerBinance\Enums\TradeType;

class BrokerSettings
{
    private TradeType $tradeType;
    private string $clientOrderId;
    private string $apiKey;
    private string $apiSecret;

    public function __construct(TradeType $tradeType, string $apiKey, string $apiSecret, string $clientOrderId = '1337')
    {
        $this->tradeType = $tradeType;
        $this->clientOrderId = $clientOrderId;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * Get the value of tradeType
     */
    public function getTradeType()
    {
        return $this->tradeType;
    }

    /**
     * Get the value of clientOrderId
     */
    public function getClientOrderId()
    {
        return $this->clientOrderId;
    }

    /**
     * Get the value of apiKey
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Get the value of apiSecret
     */
    public function getApiSecret()
    {
        return $this->apiSecret;
    }
}