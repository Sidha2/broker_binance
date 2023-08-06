<?php
declare(strict_types=1);
namespace BrokerBinance\Services;
use BrokerBinance\Repositories\BrokerRepository;
use BrokerBinance\Interface\IBrokerService;
use BrokerBinance\Models\Order;
use BrokerBinance\Models\ErrorList;
use BrokerSettings;

class BrokerService implements IBrokerService
{
    private BrokerSettings $brokerSettings;
    private BrokerRepository $brokerRepository;
    private ErrorList $errorList;
    public function __construct(BrokerRepository $brokerRepository, BrokerSettings $brokerSettings)
    {
        $this->brokerRepository = $brokerRepository;
        $this->brokerSettings = $brokerSettings;
        $this->errorList = new ErrorList();
    }

    public function OpenMarketLong(string $amount): ?Order
    {
      return $this->brokerRepository->OpenMarketLong($amount, $this->errorList);
    }
    public function OpenMarketShort(string $amount, string $price): ?Order
    {
        return $this->brokerRepository->OpenMarketShort($amount, $this->errorList);
    }
    public function OpenLimitLong(string $amount, string $price): ?Order 
    {
        return $this->brokerRepository->OpenLimitLong($amount, $price, $this->errorList);
    }
    public function OpenLimitShort(string $amount, string $price): ?Order
    {
        return $this->brokerRepository->OpenLimitShort($amount, $price, $this->errorList);
    }
}