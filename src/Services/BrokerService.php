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
    public function OpenMarketBuy(string $pair, string $amount): ?Order
    {
        return $this->brokerRepository->OpenMarket(BuySellType::BUY, $pair, $amount, $this->listMy);
    }
    public function OpenMarketSell(string $pair, string $amount): ?Order
    {
        return $this->brokerRepository->OpenMarket(buySellType::SELL, $pair, $amount, $this->listMy);
    }
    public function OpenLimitBuy(string $pair, string $amount, string $price): ?LimitOrder
    {
        return $this->brokerRepository->OpenLimit(BuySellType::BUY, $pair, $amount, $price, $this->listMy);
    }
    public function CloseLimitBuy(string $pair, string $orderId): ?Order
    {
        return $this->brokerRepository->CloseLimit(BuySellType::BUY, $pair, $orderId, $this->listMy);
    }
    public function OpenLimitSell(string $pair, string $amount, string $price): ?LimitOrder
    {
        return $this->brokerRepository->OpenLimit(BuySellType::SELL, $pair, $amount, $price, $this->listMy);
    }
    public function CloseLimitSell(string $pair, string $orderId): ?Order
    {
        return $this->brokerRepository->CloseLimit(BuySellType::SELL, $pair, $orderId, $this->listMy);
    }

    /**
     * Get the value of ListMy
     */
    public function GetErrorList(): ListMy
    {
        return $this->listMy;
    }
}