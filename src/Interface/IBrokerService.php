<?php
declare(strict_types=1);
namespace BrokerBinance\Interface;
use BrokerBinance\Models\ListMy;
use BrokerBinance\Models\Order;

interface IBrokerService
{
    public function OpenMarketLong(string $pair, string $amount): ?Order;
    public function OpenMarketShort(string $pair, string $amount): ?Order;
    public function OpenLimitLong(string $pair, string $amount, string $price): ?Order;
    public function OpenLimitShort(string $pair, string $amount, string $price): ?Order;
    public function GetErrorList(): ListMy;

}