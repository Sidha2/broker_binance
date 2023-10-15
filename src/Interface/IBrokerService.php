<?php
declare(strict_types=1);
namespace BrokerBinance\Interface;

use BrokerBinance\Models\ListMy;
use BrokerBinance\Models\Order;
use BrokerBinance\Models\LimitOrder;

interface IBrokerService
{
    public function GetTicker(string $pair): ?string;
    public function OpenMarketBuy(string $pair, string $amount): ?LimitOrder;
    public function OpenMarketSell(string $pair, string $amount): ?LImitOrder;
    public function OpenLimitBuy(string $pair, string $amount, string $price): ?LimitOrder;
    public function OpenLimitSell(string $pair, string $amount, string $price): ?LimitOrder;
    public function CloseLimit(LimitOrder $limitOrder): ?LimitOrder;
    public function GetOrder(LimitOrder $limitOrder): ?Order;
    public function GetBalance(): ?LimitOrder;
    public function GetErrorList(): ListMy;

}