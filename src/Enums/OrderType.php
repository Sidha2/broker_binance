<?php

declare(strict_types=1);
namespace BrokerBinance\Enums;

enum OrderType
{
    case MARKET;
    case LIMIT;
}