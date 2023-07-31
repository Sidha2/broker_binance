<?php
declare(strict_types=1);

namespace BrokerBinance\Models;

enum ErrorType
{
    case Exchange;
    case Internal;
}