<?php
declare(strict_types=1);
namespace BrokerBinance\Services;

use BrokerBinance\Enums\BuySellType;
use BrokerBinance\Models\LimitOrder;
use BrokerBinance\Repositories\BrokerRepository;
use BrokerBinance\Interface\IBrokerService;
use BrokerBinance\Models\Error;
use BrokerBinance\Models\Order;
use BrokerBinance\Models\ListMy;

class BrokerService implements IBrokerService
{
    private BrokerRepository $brokerRepository;
    private ListMy $listMy;
    public function __construct(BrokerRepository $brokerRepository)
    {
        $this->brokerRepository = $brokerRepository;
        $this->listMy = new ListMy(Error::class);
    }

    public function GetTicker(string $pair): ?string
    {
        return $this->brokerRepository->GetTicker($pair, $this->listMy);
    }
    public function OpenMarketBuy(string $pair, string $amount): ?LimitOrder
    {
        return $this->brokerRepository->OpenMarket(BuySellType::BUY, $pair, $amount, $this->listMy);
    }
    public function OpenMarketSell(string $pair, string $amount): ?LimitOrder
    {
        return $this->brokerRepository->OpenMarket(buySellType::SELL, $pair, $amount, $this->listMy);
    }
    public function OpenLimitBuy(string $pair, string $amount, string $price): ?LimitOrder
    {
        return $this->brokerRepository->OpenLimit(BuySellType::BUY, $pair, $amount, $price, $this->listMy);
    }
    public function OpenLimitSell(string $pair, string $amount, string $price): ?LimitOrder
    {
        return $this->brokerRepository->OpenLimit(BuySellType::SELL, $pair, $amount, $price, $this->listMy);
    }
    public function CloseLimit(LimitOrder $limitOrder): ?LimitOrder
    {
        return $this->brokerRepository->CloseLimit($limitOrder, $this->listMy);
    }
    public function GetOrder(LimitOrder $limitOrder): ?Order
    {
        return $this->brokerRepository->GetOrder($limitOrder, $this->listMy);
    }
    public function IsOrderFilled(LimitOrder $limitOrder): ?bool
    {
        return $this->brokerRepository->IsOrderFilled($limitOrder, $this->listMy);
    }
    // public function GetBalance(): ?LimitOrder
    // {
    //     return $this->brokerRepository->GetBalance($this->listMy);
    // }

    /**
     * Get the value of ListMy
     */
    public function GetErrorList(): ListMy
    {
        return $this->listMy;
    }
}