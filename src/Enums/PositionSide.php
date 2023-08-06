<?php

declare(strict_types=1);
namespace BrokerBinance\Models;

enum PositionSide
{
    case LONG;
    case SHORT;
}