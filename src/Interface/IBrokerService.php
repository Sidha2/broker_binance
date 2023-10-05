<?php
declare(strict_types=1);
namespace BrokerBinance\Interface;

use BrokerBinance\Models\ListMy;
use BrokerBinance\Models\Order;

interface IBrokerService
{
    public function GetTicker(string $pair): ?string;
    public function OpenMarketBuy(string $pair, string $amount): ?Order;
    public function OpenMarketSell(string $pair, string $amount): ?Order;
    public function OpenLimitBuy(string $pair, string $amount, string $price): ?Order;
    public function CloseLimitBuy(string $pair, string $orderId): ?Order;
    public function OpenLimitSell(string $pair, string $amount, string $price): ?Order;
    public function CloseLimitSell(string $pair, string $orderId): ?Order;
    public function GetErrorList(): ListMy;

}