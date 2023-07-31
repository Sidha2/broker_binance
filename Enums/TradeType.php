<?php

declare(strict_types=1);
namespace BrokerBinance\Models;

enum TradeType
{
    case Spot;
    case Margin;
    case Futures;
}