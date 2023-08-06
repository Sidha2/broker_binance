<?php
declare(strict_types=1);
namespace BrokerBinance\Services;
use BrokerBinance\Repositories\BrokerRepository;
use BrokerBinance\Interface\IBrokerService;
use BrokerBinance\Models\Error;
use BrokerBinance\Models\Order;
use BrokerBinance\Models\ListMy;

class BrokerService implements IBrokerService
{
    private BrokerRepository $brokerRepository;
    private ListMy $ListMy;
    public function __construct(BrokerRepository $brokerRepository)
    {
        $this->brokerRepository = $brokerRepository;
        $this->ListMy = new ListMy(Error::class);
    }

    public function OpenMarketLong(string $amount): ?Order
    {
      return $this->brokerRepository->OpenMarketLong($amount, $this->ListMy);
    }
    public function OpenMarketShort(string $amount): ?Order
    {
        return $this->brokerRepository->OpenMarketShort($amount, $this->ListMy);
    }
    public function OpenLimitLong(string $amount, string $price): ?Order 
    {
        return $this->brokerRepository->OpenLimitLong($amount, $price, $this->ListMy);
    }
    public function OpenLimitShort(string $amount, string $price): ?Order
    {
        return $this->brokerRepository->OpenLimitShort($amount, $price, $this->ListMy);
    }

    /**
     * Get the value of ListMy
     */ 
    public function GetErrorList()
    {
        return $this->ListMy;
    }
}