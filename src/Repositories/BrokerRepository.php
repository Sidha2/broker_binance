<?php
declare(strict_types=1);
namespace BrokerBinance\Repositories;

use BrokerBinance\Models\BinanceOrder;
use BrokerBinance\Models\Error;
use BrokerBinance\Models\ListMy;
use BrokerBinance\Enums\ErrorType;
use BrokerBinance\Enums\BuySellType;
use BrokerBinance\Enums\OrderType;
use BrokerBinance\Models\Order;
use BrokerBinance\Enums\PositionSide;
use BrokerBinance\Enums\TradeType;
use BrokerBinance\Models\BrokerSettings;
use Lin\Binance\Binance;
use Lin\Binance\BinanceFuture;

class BrokerRepository
{
    private BrokerSettings $brokerSettings;
    private BinanceFuture|Binance $binance;


    public function __construct(BrokerSettings $brokerSettings)
    {
        $this->brokerSettings = $brokerSettings;
        switch ($brokerSettings->getTradeType())
        {
            case TradeType::SPOT:
                $this->binance = new Binance($brokerSettings->getApiKey(), $brokerSettings->getApiSecret());
                break;
            case TradeType::FUTURES:
                $this->binance = new BinanceFuture($brokerSettings->getApiKey(), $brokerSettings->getApiSecret());
                break;
            case TradeType::MARGIN:
                $this->binance = new Binance($brokerSettings->getApiKey(), $brokerSettings->getApiSecret());
                break;
            default:
                $this->binance = new Binance($brokerSettings->getApiKey(), $brokerSettings->getApiSecret());
                break;
        }
    }

    public function GetTicker(string $pair, ListMy $listMy): ?string
    {
        try
        {
            $result = $this->binance->market()->getTickerPrice([
                'symbol' => $pair,
            ]);
            if (isset($result['price']))
                return $result['price'];

            if (isset($result['msg']))
            {
                $this->ExceptionHandler($result, ErrorType::Exchange, "Ticker for pair '$pair' was not fetched", $listMy);
            }

            return null;
        }
        catch (\Exception $e)
        {
            $this->ExceptionHandler($e, ErrorType::Exchange, "Ticker for pair '$pair' was not fetched", $listMy);
            return null;
        }
    }

    public function OpenMarket(BuySellType $buySellType, string $pair, string $amount, ListMy $listMy): ?Order
    {
        try
        {
            $result = $this->binance->trade()->postOrder([
                'symbol'   => $pair,
                'side'     => $buySellType === BuySellType::BUY ? 'BUY' : 'SELL',
                'type'     => OrderType::MARKET->name,
                'quantity' => $amount,
            ]);
            return $this->MapResultToOrder($result);
        }
        catch (\Exception $e)
        {
            $this->ExceptionHandler($e, ErrorType::Exchange, "OpenMarketBuy", $listMy);
            return null;
        }
    }

    public function OpenLimit(BuySellType $buySellType, string $pair, string $amount, string $price, ListMy $listMy): ?Order
    {
        try
        {
            $result = $this->binance->trade()->postOrder([
                'symbol'      => $pair,
                'side'        => $buySellType === BuySellType::BUY ? 'BUY' : 'SELL',
                'type'        => OrderType::LIMIT->name,
                'quantity'    => $amount,
                'price'       => $price,
                'timeInForce' => 'GTC',
            ]);
            return $this->MapResultToOrder($result);
        }
        catch (\Exception $e)
        {
            $this->ExceptionHandler($e, ErrorType::Exchange, $buySellType === BuySellType::BUY ? "OpenLimit - Buy" : "OpenLimit - Sell", $listMy);
            return null;
        }
    }

    public function CloseLimit(BuySellType $buySellType, string $pair, string $orderId, ListMy $listMy)
    {
        try
        {
            $result = $this->binance->trade()->deleteOrder([
                'symbol'  => $pair,
                'orderId' => $orderId,
            ]);
            return $this->MapResultToOrder($result);
        }
        catch (\Exception $e)
        {
            $this->ExceptionHandler($e, ErrorType::Exchange, $buySellType === BuySellType::BUY ? "CloseLimit - Buy" : "CloseLimit - Sell", $listMy);
            return null;
        }
    }

    private function MapResultToOrder(BinanceOrder $result): ?Order
    {
        if (is_null($result))
            return null;

        $order = new Order();
        $order->orderId = intval($result->orderId);
        $order->avgPrice = $result->avgPrice;
        $order->cumQuote = $result->cumQuote;
        $order->executedQty = $result->executedQty;
        $order->openCloseType = $this->MapBuySellType($result->side);
        $order->positionSide = $this->MapPositionSide($result->positionSide);
        $order->orderType = $this->MapOrderType($result->type);
        $order->origQty = $result->origQty;
        $order->symbol = $result->symbol;
        $order->targetPrice = $result->stopPrice;
        $order->time = $result->time;

    }

    private function MapBuySellType(string $buySellType): BuySellType
    {
        switch ($buySellType)
        {
            case 'BUY':
                return BuySellType::BUY;
            case 'SELL':
                return BuySellType::SELL;

            default:
                throw new \Exception("Unknown open/close type: " . $buySellType);
        }
    }

    private function MapPositionSide(string $positionSide): PositionSide
    {
        switch ($positionSide)
        {
            case 'LONG':
                return PositionSide::LONG;
            case 'SHORT':
                return PositionSide::SHORT;

            default:
                throw new \Exception("Unknown position side type: " . $positionSide);
        }
    }

    private function MapOrderType(string $orderType): OrderType
    {
        switch ($orderType)
        {
            case 'MARKET':
                return OrderType::MARKET;
            case 'LIMIT':
                return OrderType::LIMIT;

            default:
                throw new \Exception("Unknown order type: " . $orderType);
        }
    }
    private function ExceptionHandler(\Throwable $e, ErrorType $errorType, string $comesFrom, ListMy $listMy): void
    {
        $errorMessage = "Can't parse error msg";
        try
        {
            $error = json_decode($e->getMessage());
            $errorMessage = isset($error->msg) ? $error->msg : (isset($error->message) ? $error->message : $e->getMessage());
        }
        catch (\Throwable $th)
        {
            // Ignore
        }

        $listMy->Add(new Error(
            $errorType,
            $errorMessage,
            $comesFrom,
            $e->getFile(),
            $e->getLine()));
    }

    /**
     * Get the value of brokerSettings
     */
    public function getBrokerSettings(): BrokerSettings
    {
        return $this->brokerSettings;
    }
}