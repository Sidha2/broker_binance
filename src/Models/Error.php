<?php
declare(strict_types=1);
namespace BrokerBinance\Models;

use BrokerBinance\Enums\ErrorType;

class Error
{
    public string $msg;
    public ErrorType $errorType;
    public string $comesFrom;
    public string $file;
    public int $line;
    public int $timestamp;

    public function __construct(ErrorType $errorType, string $msg, string $comesFrom, string $file, int $line)
    {
        $this->errorType = $errorType;
        $this->msg = $msg;
        $this->comesFrom = $comesFrom;
        $this->file = $file;
        $this->line = $line;
        $this->timestamp = time();
    }
}