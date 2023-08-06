<?php

declare(strict_types=1);
namespace BrokerBinance\Enums;

enum TradeType
{
    case SPOT;
    case MARGIN;
    case FUTURES;
}