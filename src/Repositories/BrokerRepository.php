<?php
declare(strict_types=1);
namespace BrokerBinance\Repositories;

use BrokerBinance\Models\BinanceOrder;
use BrokerBinance\Models\Error;
use BrokerBinance\Models\ErrorList;
use BrokerBinance\Models\ErrorType;
use BrokerBinance\Models\OpenCloseType;
use BrokerBinance\Models\OrderType;
use BrokerBinance\Models\Order;
use BrokerBinance\Models\PositionSide;
use BrokerBinance\Models\TradeType;
use BrokerSettings;
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

    public function OpenMarketLong(string $amount, ErrorList $errorList): ?Order
    {
        try
        {
            $result = $this->binance->trade()->postOrder([
                'symbol'      => $this->brokerSettings->getPair(),
                'side'        => 'BUY',
                'type'        => OrderType::MARKET,
                'quantity'    => $amount,
                'timeInForce' => 'GTC',
            ]);
            return $this->MapResultToOrder($result);
        }
        catch (\Exception $e)
        {
            $this->ExceptionHandler($e, ErrorType::Internal, "OpenMarketLong", $errorList);
            return null;
        }
    }
    public function OpenMarketShort(string $amount, ErrorList $errorList): ?Order
    {
        try
        {
            $result = $this->binance->trade()->postOrder([
                'symbol'      => $this->brokerSettings->getPair(),
                'side'        => 'SELL',
                'type'        => OrderType::MARKET,
                'quantity'    => $amount,
                'timeInForce' => 'GTC',
            ]);
            return $this->MapResultToOrder($result);
        }
        catch (\Exception $e)
        {
            $this->ExceptionHandler($e, ErrorType::Internal, "OpenMarketShort", $errorList);
            return null;
        }
    }

    public function OpenLimitLong(string $amount, string $price, ErrorList $errorList): ?Order
    {
        try
        {
            $result = $this->binance->trade()->postOrder([
                'symbol'      => $this->brokerSettings->getPair(),
                'side'        => 'BUY',
                'type'        => OrderType::LIMIT,
                'quantity'    => $amount,
                'price'       => $price,
                'timeInForce' => 'GTC',
            ]);
            return $this->MapResultToOrder($result);
        }
        catch (\Exception $e)
        {
            $this->ExceptionHandler($e, ErrorType::Internal, "OpenLimitLong", $errorList);
            return null;
        }
    }

    public function OpenLimitShort(string $amount, string $price, ErrorList $errorList): ?Order
    {
        try
        {
            $result = $this->binance->trade()->postOrder([
                'symbol'      => $this->brokerSettings->getPair(),
                'side'        => 'SELL',
                'type'        => OrderType::LIMIT,
                'quantity'    => $amount,
                'price'       => $price,
                'timeInForce' => 'GTC',
            ]);
            return $this->MapResultToOrder($result);
        }
        catch (\Exception $e)
        {
            $this->ExceptionHandler($e, ErrorType::Internal, "OpenLimitShort", $errorList);
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
        $order->openCloseType = $this->MapOpenCloseType($result->side);
        $order->positionSide = $this->MapPositionSide($result->positionSide);
        $order->orderType = $this->MapOrderType($result->type);
        $order->origQty = $result->origQty;
        $order->symbol = $result->symbol;
        $order->targetPrice = $result->stopPrice;
        $order->time = $result->time;

    }

    private function MapOpenCloseType(string $openCLoseType): OpenCloseType
    {
        switch ($openCLoseType)
        {
            case 'BUY':
                return OpenCloseType::OPEN;
            case 'SELL':
                return OpenCloseType::CLOSE;

            default:
                throw new \Exception("Unknown open/close type: " . $openCLoseType);
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
    private function ExceptionHandler(\Throwable $e, ErrorType $errorType, string $comesFrom, ErrorList $errorList)
    {
        $time = time();
    }
}