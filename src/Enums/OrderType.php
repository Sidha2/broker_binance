<?php

declare(strict_types=1);
namespace BrokerBinance\Models;

enum OrderType
{
    case MARKET;
    case LIMIT;
}