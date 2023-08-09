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

    public function OpenMarketLong(string $pair, string $amount): ?Order
    {
      return $this->brokerRepository->OpenMarketLong($pair, $amount, $this->ListMy);
    }
    public function OpenMarketShort(string $pair, string $amount): ?Order
    {
        return $this->brokerRepository->OpenMarketShort($pair, $amount, $this->ListMy);
    }
    public function OpenLimitLong(string $pair, string $amount, string $price): ?Order 
    {
        return $this->brokerRepository->OpenLimitLong($pair, $amount, $price, $this->ListMy);
    }
    public function OpenLimitShort(string $pair, string $amount, string $price): ?Order
    {
        return $this->brokerRepository->OpenLimitShort($pair, $amount, $price, $this->ListMy);
    }

    /**
     * Get the value of ListMy
     */ 
    public function GetErrorList(): ListMy
    {
        return $this->ListMy;
    }
}