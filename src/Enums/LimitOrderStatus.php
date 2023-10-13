<?php

declare(strict_types=1);
namespace BrokerBinance\Enums;

enum LimitOrderStatus
{
    case NEW;
    case CANCELED;
    case FILLED;
}