<?php
declare(strict_types=1);
namespace BrokerBinance\Repositories;

use BrokerBinance\Models\Error;
use BrokerBinance\Models\Position;
use BrokerSettings;

class BrokerRepository
{
    private BrokerSettings $brokerSettings;


    public function __construct(BrokerSettings $brokerSettings)
    {
        $this->brokerSettings = $brokerSettings;
    }
    public function OpenMarketLong(string $amount): ?Position
    {

    }
    public function OpenMarketShort(string $amount): bool
    {

    }
    public function OpenLimitLong(string $amount, string $price): bool
    {

    }
    public function OpenLimitShort(string $amount, string $price): bool
    {

    }

    public function MapResultToPosition(): ?Position
    {

    }
}