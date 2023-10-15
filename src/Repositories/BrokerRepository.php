<?php
declare(strict_types=1);
namespace BrokerBinance\Repositories;

use BrokerBinance\Models\BinanceGetOrder;
use BrokerBinance\Models\BinanceLimitCloseOrder;
use BrokerBinance\Models\BinanceLimitOpenOrder;
use BrokerBinance\Models\Error;
use BrokerBinance\Models\LimitOrder;
use BrokerBinance\Models\ListMy;
use BrokerBinance\Enums\ErrorType;
use BrokerBinance\Enums\BuySellType;
use BrokerBinance\Enums\OrderType;
use BrokerBinance\Models\Order;
use BrokerBinance\Enums\TradeType;
use BrokerBinance\Models\BrokerSettings;
use JsonMapper;
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
            switch ($this->brokerSettings->getTradeType())
            {
                case TradeType::SPOT:
                    $result = $this->binance->system()->getTickerPrice([
                        'symbol' => $pair,
                    ]);
                    break;
                case TradeType::FUTURES:
                    $result = $this->binance->market()->getTickerPrice([
                        'symbol' => $pair,
                    ]);
                    break;
                case TradeType::MARGIN:
                    $result = $this->binance->system()->getTickerPrice([
                        'symbol' => $pair,
                    ]);
                    break;
                default:
                    $result = $this->binance->system()->getTickerPrice([
                        'symbol' => $pair,
                    ]);
                    break;
            }

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

    public function OpenMarket(BuySellType $buySellType, string $pair, string $amount, ListMy $listMy): ?LimitOrder
    {
        try
        {
            $inputParams = [
                'symbol'   => $pair,
                'side'     => $buySellType === BuySellType::BUY ? 'BUY' : 'SELL',
                'type'     => OrderType::MARKET->name,
                'quantity' => $amount
            ];
            $result = $this->binance->trade()->postOrder($inputParams);
            return $this->MapResultToLimitOpenOrder((new JsonMapper())->map((object)$result, BinanceLimitOpenOrder::class), $inputParams);
        }
        catch (\Exception $e)
        {
            $this->ExceptionHandler($e, ErrorType::Exchange, $buySellType === BuySellType::BUY ? "OpenMarket - Buy" : "OpenMarket - Sell", $listMy);
            return null;
        }
    }

    public function OpenLimit(BuySellType $buySellType, string $pair, string $amount, string $price, ListMy $listMy): ?LimitOrder
    {
        try
        {
            $inputParams = [
                'symbol'      => $pair,
                'side'        => $buySellType === BuySellType::BUY ? 'BUY' : 'SELL',
                'type'        => OrderType::LIMIT->name,
                'quantity'    => $amount,
                'price'       => $price,
                'timeInForce' => 'GTC',
            ];
            $result = $this->binance->trade()->postOrder($inputParams);
            return $this->MapResultToLimitOpenOrder((new JsonMapper())->map((object)$result, BinanceLimitOpenOrder::class), $inputParams);
        }
        catch (\Exception $e)
        {
            $this->ExceptionHandler($e, ErrorType::Exchange, $buySellType === BuySellType::BUY ? "OpenLimit - Buy" : "OpenLimit - Sell", $listMy);
            return null;
        }
    }

    public function CloseLimit(LimitOrder $limitOrder, ListMy $listMy): ?LimitOrder
    {
        try
        {
            $result = $this->binance->trade()->deleteOrder([
                'symbol'  => $limitOrder->symbol,
                'orderId' => $limitOrder->orderId,
            ]);
            return $this->MapResultToLimitCloseOrder((new JsonMapper())->map((object)$result, BinanceLimitCloseOrder::class));
        }
        catch (\Exception $e)
        {
            $this->ExceptionHandler($e, ErrorType::Exchange, "CloseLimit", $listMy);
            return null;
        }
    }

    // TODO user()-> don't have get balance wtf
    // public function GetBalance(ListMy $listMy): ?LimitOrder
    // {
    //     try
    //     {
    //         $result = $this->binance->user()->getBalance();
    //         print_r($result);
    //         die();
    //         // return $this->MapResultToLimitCloseOrder((new JsonMapper())->map((object)$result, BinanceLimitCloseOrder::class));
    //     }
    //     catch (\Exception $e)
    //     {
    //         $this->ExceptionHandler($e, ErrorType::Exchange, "CloseLimit", $listMy);
    //         return null;
    //     }
    // }

    public function GetOrder(LimitOrder $limitOrder, ListMy $listMy): ?Order
    {
        try
        {
            $result = $this->binance->user()->getOrder([
                'symbol'  => $limitOrder->symbol,
                'orderId' => $limitOrder->orderId,
                // 'origClientOrderId' => $limitOrder->clientOrderId,
            ]);
            return $this->MapResultToOrder((new JsonMapper())->map((object)$result, BinanceGetOrder::class));
        }
        catch (\Exception $e)
        {
            $this->ExceptionHandler($e, ErrorType::Exchange, "GetOrder", $listMy);
            return null;
        }
    }

    private function MapResultToOrder(BinanceGetOrder $result): ?Order
    {
        if (is_null($result))
            return null;

        $order = new Order();
        $order->orderId = intval($result->orderId);
        $order->avgPrice = $result->price == 0 ? strval(round($result->cummulativeQuoteQty / $result->origQty, 8)) : $result->price;
        $order->cumQuote = $result->cummulativeQuoteQty;
        $order->executedQty = $result->executedQty;
        $order->openCloseType = $this->MapBuySellType($result->side);
        $order->orderType = $this->MapOrderType($result->type);
        $order->origQty = $result->origQty;
        $order->symbol = $result->symbol;
        $order->targetPrice = $result->stopPrice;
        $order->time = $result->time;

        return $order;
    }

    private function MapResultToLimitOpenOrder(BinanceLimitOpenOrder $result, array $inputParams): ?LimitOrder
    {
        if (is_null($result))
            return null;

        $order = new LimitOrder();
        $order->orderId = intval($result->orderId);
        $order->price = $inputParams['price'] ?? '0';
        $order->quantity = $inputParams['quantity'];
        $order->positionSide = $inputParams['side'];
        $order->symbol = $result->symbol;
        $order->time = $result->transactTime;
        $order->clientOrderId = $result->clientOrderId;
        return $order;
    }

    private function MapResultToLimitCloseOrder(BinanceLimitCloseOrder $result): ?LimitOrder
    {
        if (is_null($result))
            return null;

        $order = new LimitOrder();
        $order->orderId = intval($result->orderId);
        $order->price = $result->price;
        $order->quantity = $result->executedQty;
        $order->positionSide = $result->side;
        $order->symbol = $result->symbol;
        $order->time = $result->transactTime;
        $order->clientOrderId = $result->clientOrderId;
        $order->status = $result->status;

        return $order;
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