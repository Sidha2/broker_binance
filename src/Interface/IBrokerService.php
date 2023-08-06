<?php
declare(strict_types=1);
namespace BrokerBinance\Interface;
use BrokerBinance\Models\Order;

interface IBrokerService
{
    public function OpenMarketLong(string $amount): ?Order;
    public function OpenMarketShort(string $amount): ?Order;
    public function OpenLimitLong(string $amount, string $price): ?Order;
    public function OpenLimitShort(string $amount, string $price): ?Order;

}