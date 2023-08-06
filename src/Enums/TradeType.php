<?php

declare(strict_types=1);
namespace BrokerBinance\Models;

enum TradeType
{
    case SPOT;
    case MARGIN;
    case FUTURES;
}