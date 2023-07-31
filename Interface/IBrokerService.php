<?php
declare(strict_types=1);
namespace BrokerBinance\Interface;

interface IBrokerService
{
    public function OpenMarketLong(string $amount): bool;
    public function OpenMarketShort(string $amount): bool;
    public function OpenLimitLong(string $amount, string $price): bool;
    public function OpenLimitShort(string $amount, string $price): bool;

}