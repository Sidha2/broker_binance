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

    public function OpenMarketBuy(string $pair, string $amount): ?Order
    {
        return $this->brokerRepository->OpenMarketBuy($pair, $amount, $this->ListMy);
    }
    public function OpenMarketSell(string $pair, string $amount): ?Order
    {
        return $this->brokerRepository->OpenMarketSell($pair, $amount, $this->ListMy);
    }
    public function OpenLimitBuy(string $pair, string $amount, string $price): ?Order
    {
        return $this->brokerRepository->OpenLimitBuy($pair, $amount, $price, $this->ListMy);
    }
    public function OpenLimitSell(string $pair, string $amount, string $price): ?Order
    {
        return $this->brokerRepository->OpenLimitSell($pair, $amount, $price, $this->ListMy);
    }

    /**
     * Get the value of ListMy
     */
    public function GetErrorList(): ListMy
    {
        return $this->ListMy;
    }
}