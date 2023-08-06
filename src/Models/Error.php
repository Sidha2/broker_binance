<?php
declare(strict_types=1);
namespace BrokerBinance\Models;

class Error
{
    public string $msg;
    public ErrorType $errorType;
    public int $timestamp;

    public function __construct(ErrorType $errorType, string $msg)
    {
        $this->errorType = $errorType;
        $this->msg = $msg;
    }
}