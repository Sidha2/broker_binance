<?php
declare(strict_types=1);

namespace BrokerBinance\Enums;

enum ErrorType
{
    case Exchange;
    case Internal;
}