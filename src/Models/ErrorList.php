<?php
declare(strict_types=1);
namespace BrokerBinance\Models;

use BrokerBinance\Models\ListOfObjects;

class ErrorList extends ListOfObjects
{
    private array $errors = [];
    public function __construct()
    {
    }

}