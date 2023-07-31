<?php
declare(strict_types=1);
namespace BrokerBinance\Services;
use BrokerBinance\Repositories\BrokerRepository;
use BrokerBinance\Interface\IBrokerService;
use BrokerSettings;

class BrokerService implements IBrokerService
{
    private BrokerSettings $brokerSettings;
    private BrokerRepository $brokerRepository;
    public function __construct(BrokerRepository $brokerRepository, BrokerSettings $brokerSettings)
    {
        $this->brokerRepository = $brokerRepository;
        $this->brokerSettings = $brokerSettings;
    }

    public function OpenMarketLong(string $amount): bool
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
}