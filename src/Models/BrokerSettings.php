<?php
declare(strict_types=1);
use BrokerBinance\Models\TradeType;

class BrokerSettings
{
    private string $pair;
    private TradeType $tradeType;
    private string $clientOrderId;
    private string $apiKey;
    private string $apiSecret;

    public function __construct(string $pair, TradeType $tradeType, string $clientOrderId, string $apiKey, string $apiSecret)
    {
        $this->tradeType = $tradeType;
        $this->pair = $pair;
        $this->clientOrderId = $clientOrderId;
        $this->apiKey = $apiKey;
        $this->apiSecret;
    }

    /**
     * Get the value of pair
     */
    public function getPair()
    {
        return $this->pair;
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